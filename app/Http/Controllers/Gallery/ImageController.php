<?php

namespace App\Http\Controllers\Gallery;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\Gallery\Image;
use App\Models\Gallery\Group;

// Requests
use App\Http\Requests\Gallery\Image\IndexRequest;
use App\Http\Requests\Gallery\Image\StoreRequest;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): View
    {
        $validated = $request->validated();
        $limit = $validated['limit'] ?? 10;

        $query = Image::query()->orderBy('created_at', 'desc');

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

        $images = $query->paginate($limit)->appends($request->except('page'));
        $groups = Group::all();

        return view('pages.dashboard.admin.gallery.image.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'images' => $images,
            'groups' => $groups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $groups = Group::all();
        return view('pages.dashboard.admin.gallery.image.create', [
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

        if ($request->hasFile('image_file')) {
            $validated['file_path'] = $request->file('image_file')->store('gallery/images', 'public');
        }

        Image::create($validated);

        return redirect()->route('dashboard.admin.gallery.images.index')->with('success', 'Image has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
}
