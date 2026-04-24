<?php

namespace App\Http\Controllers\MasterData;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

// Models
use App\Models\MasterData\Mission;

// Requests
use App\Http\Requests\MasterData\Mission\IndexRequest;
use App\Http\Requests\MasterData\Mission\StoreRequest;
use Illuminate\Http\RedirectResponse;

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
    public function show(Mission $mission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mission $mission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mission $mission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mission $mission)
    {
        //
    }
}
