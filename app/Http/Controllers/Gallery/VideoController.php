<?php

namespace App\Http\Controllers\Gallery;

use Carbon\Carbon;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\Gallery\Video;
use App\Models\Gallery\Group;

// Requests
use App\Http\Requests\Gallery\Video\IndexRequest;
use App\Http\Requests\Gallery\Video\StoreRequest;
use App\Http\Requests\Gallery\Video\UpdateRequest;

// Jobs
use App\Jobs\GenerateVideoThumbnailJob;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): View
    {
        $validated = $request->validated();
        $limit = $validated['limit'] ?? 10;

        $query = Video::query()->with(['group'])->orderBy('created_at', 'desc');

        if (isset($validated['group_id'])) {
            if ($validated['group_id'] === 0) {
                $query->whereNull('group_id');
            } else {
                $query->where('group_id', $validated['group_id']);
            }
        }
        if (isset($validated['start_date'])) {
            $query->where('created_at', '>=', Carbon::parse($validated['start_date'])->startOfDay());
        }
        if (isset($validated['end_date'])) {
            $query->where('created_at', '<=', Carbon::parse($validated['end_date'])->endOfDay());
        }

        $videos = $query->paginate($limit)->appends($request->except('page'));
        $groups = Group::all();

        return view('pages.dashboard.admin.gallery.video.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'videos' => $videos,
            'groups' => $groups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $groups = Group::all();
        return view('pages.dashboard.admin.gallery.video.create', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'groups' => $groups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('video_file')) {
            $validated['file_path'] = $request->file('video_file')->store('gallery/videos', 'public');
        }

        $video = Video::create($validated);

        GenerateVideoThumbnailJob::dispatch($video);

        return redirect()->route('dashboard.admin.gallery.videos.index')->with('success', 'Video created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video): View
    {
        return view('pages.dashboard.admin.gallery.video.show', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'video' => $video->load(['group']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video): View
    {
        $groups = Group::all();
        return view('pages.dashboard.admin.gallery.video.edit', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'video' => $video,
            'groups' => $groups,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Video $video):RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('video_file')) {
            if ($video->file_path && Storage::disk('public')->exists($video->file_path)) {
                Storage::disk('public')->delete($video->file_path);
            }
            if ($video->thumbnail_path && Storage::disk('public')->exists($video->thumbnail_path)) {
                Storage::disk('public')->delete($video->thumbnail_path);
            }
            $validated['file_path'] = $request->file('video_file')->store('gallery/videos', 'public');
            $validated['thumbnail_path'] = null;
        }

        $video->update($validated);

        if ($request->hasFile('video_file')) {
            GenerateVideoThumbnailJob::dispatch($video->fresh());
        }

        return redirect()->route('dashboard.admin.gallery.videos.index')->with('success', 'Video updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video): RedirectResponse
    {
        if ($video->file_path && Storage::disk('public')->exists($video->file_path)) {
            Storage::disk('public')->delete($video->file_path);
        }
        if ($video->thumbnail_path && Storage::disk('public')->exists($video->thumbnail_path)) {
            Storage::disk('public')->delete($video->thumbnail_path);
        }

        $video->delete();

        return redirect()->route('dashboard.admin.gallery.videos.index')->with('success', 'Video deleted successfully.');
    }
}
