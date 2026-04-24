<?php

namespace App\Http\Controllers\MasterData;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\MasterData\Mission;

// Requests
use App\Http\Requests\MasterData\Mission\IndexRequest;
use App\Http\Requests\MasterData\Mission\StoreRequest;
use App\Http\Requests\MasterData\Mission\UpdateRequest;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): View
    {
        $validated = $request->validated();
        $limit = $validated['limit'] ?? 10;

        $query = Mission::query()->orderBy('order', 'asc');

        if (isset($validated['content'])) {
            $query->where('content', 'ILIKE', '%' . $validated['content'] . '%');
        }
        if (isset($validated['startOrder'])) {
            $query->where('order', '>=', $validated['startOrder']);
        }
        if (isset($validated['endOrder'])) {
            $query->where('order', '<=', $validated['endOrder']);
        }
        if (isset($validated['startDate'])) {
            $query->where('created_at', '>=', Carbon::parse($validated['startDate'])->startOfDay());
        }
        if (isset($validated['endDate'])) {
            $query->where('created_at', '<=', Carbon::parse($validated['endDate'])->endOfDay());
        }

        $missions = $query->paginate($limit)->appends($request->except('page'));

        return view('pages.dashboard.admin.master-data.mission.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'missions' => $missions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $allowedMaxOrder = Mission::count() + 1;
        return view('pages.dashboard.admin.master-data.mission.create', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'allowedMaxOrder' => $allowedMaxOrder,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            Mission::where('order', '>=', $validated['order'])
                ->lockForUpdate()
                ->increment('order');
            Mission::create($validated);
        });

        return redirect()->route('dashboard.admin.master-data.missions.index')->with('success', 'Mission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mission $mission): View
    {
        return view('pages.dashboard.admin.master-data.mission.show', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'mission' => $mission,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mission $mission): View
    {
        $allowedMaxOrder = Mission::count();
        return view('pages.dashboard.admin.master-data.mission.edit', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'allowedMaxOrder' => $allowedMaxOrder,
            'mission' => $mission,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Mission $mission): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $mission) {
            $mission = Mission::where('id', $mission->id)
                ->lockForUpdate()
                ->first();
            if ($validated['order'] != $mission->order) {
                if ($validated['order'] < $mission->order) {
                    Mission::where('order', '>=', $validated['order'])
                        ->where('order', '<', $mission->order)
                        ->lockForUpdate()
                        ->increment('order');
                } else {
                    Mission::where('order', '>', $mission->order)
                        ->where('order', '<=', $validated['order'])
                        ->lockForUpdate()
                        ->decrement('order');
                }
            }
            $mission->update($validated);
        });

        return redirect()->route('dashboard.admin.master-data.missions.index')->with('success', 'Mission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mission $mission): RedirectResponse
    {
        DB::transaction(function () use ($mission) {
            $mission = Mission::where('id', $mission->id)
                ->lockForUpdate()
                ->first();
            $deletedOrder = $mission->order;
            $mission->delete();
            Mission::where('order', '>', $deletedOrder)
                ->lockForUpdate()
                ->decrement('order');
        });

        return redirect()->route('dashboard.admin.master-data.missions.index')->with('success', 'Mission deleted successfully.');
    }
}
