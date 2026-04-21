<?php

namespace App\Http\Controllers\MasterData;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\MasterData\Vision;

// Requests
use App\Http\Requests\MasterData\Vision\IndexRequest;
use App\Http\Requests\MasterData\Vision\StoreRequest;
use App\Http\Requests\MasterData\Vision\UpdateRequest;

class VisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): View
    {
        $validated = $request->validated();
        $limit = $validated['limit'] ?? 10;

        $query = Vision::query();

        if (isset($validated['content'])) {
            $query->where('content', 'ILIKE', '%' . $validated['content'] . '%');
        }
        if (isset($validated['start_order'])) {
            $query->where('order', '>=', $validated['start_order']);
        }
        if (isset($validated['end_order'])) {
            $query->where('order', '<=', $validated['end_order']);
        }
        if (isset($validated['start_date'])) {
            $query->where('created_at', '>=', Carbon::parse($validated['start_date'])->startOfDay());
        }
        if (isset($validated['end_date'])) {
            $query->where('created_at', '<=', Carbon::parse($validated['end_date'])->endOfDay());
        }

        $visions = $query->paginate($limit)->appends($request->except('page'));

        return view('pages.dashboard.admin.master-data.vision.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'visions' => $visions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $allowed_max_order = vision::count() + 1;
        return view('pages.dashboard.admin.master-data.vision.create', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'allowed_max_order' => $allowed_max_order,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            Vision::where('order', '>=', $validated['order'])
                ->lockForUpdate()
                ->increment('order');
            Vision::create($validated);
        });

        return redirect()->route('dashboard.admin.master-data.visions.index')->with('success', 'Vision created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vision $vision): View
    {
        return view('pages.dashboard.admin.master-data.vision.show', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'vision' => $vision,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vision $vision): View
    {
        $allowed_max_order = vision::count();
        return view('pages.dashboard.admin.master-data.vision.edit', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'allowed_max_order' => $allowed_max_order,
            'vision' => $vision,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Vision $vision): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $vision) {
            if ($validated['order'] != $vision->order) {
                if ($validated['order'] < $vision->order) {
                    Vision::where('order', '>=', $validated['order'])
                        ->where('order', '<', $vision->order)
                        ->lockForUpdate()
                        ->increment('order');
                } else {
                    Vision::where('order', '>', $vision->order)
                        ->where('order', '<=', $validated['order'])
                        ->lockForUpdate()
                        ->decrement('order');
                }
            }
            $vision->update($validated);
        });

        return redirect()->route('dashboard.admin.master-data.visions.index')->with('success', 'Vision updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vision $vision): RedirectResponse
    {
        DB::transaction(function () use ($vision) {
            $deletedOrder = $vision->order;
            $vision->delete();
            Vision::where('order', '>', $deletedOrder)
                ->lockForUpdate()
                ->decrement('order');
        });

        return redirect()->route('dashboard.admin.master-data.visions.index')->with('success', 'Vision deleted successfully.');
    }
}
