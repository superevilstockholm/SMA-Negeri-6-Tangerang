<?php

namespace App\Http\Controllers\MasterData;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\MasterData\SchoolHistory;

// Requests
use App\Http\Requests\MasterData\SchoolHistory\IndexRequest;
use App\Http\Requests\MasterData\SchoolHistory\StoreRequest;
use App\Http\Requests\MasterData\SchoolHistory\UpdateRequest;

class SchoolHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): View
    {
        $validated = $request->validated();
        $limit = $validated['limit'] ?? 10;

        $query = SchoolHistory::query()->orderBy('order', 'asc');

        if (isset($validated['title'])) {
            $query->where('title', 'ILIKE', '%' . $validated['title'] . '%');
        }
        if (isset($validated['description'])) {
            $query->where('description', 'ILIKE', '%' . $validated['description'] . '%');
        }
        if (isset($validated['startYear']) || isset($validated['endYear'])) {
            $query->where(function ($q) use ($validated) {
                $startYear = $validated['startYear'] ?? null;
                $endYear   = $validated['endYear'] ?? null;
                if ($startYear && $endYear) {
                    $q->where('start_year', '<=', $endYear)
                    ->where(function ($qq) use ($startYear) {
                        $qq->whereNull('end_year')
                            ->orWhere('end_year', '>=', $startYear);
                    });
                } elseif ($startYear) {
                    $q->where(function ($qq) use ($startYear) {
                        $qq->where('start_year', '>=', $startYear)
                        ->orWhere('end_year', '>=', $startYear);
                    });
                } elseif ($endYear) {
                    $q->where(function ($qq) use ($endYear) {
                        $qq->where('start_year', '<=', $endYear)
                        ->orWhere('end_year', '<=', $endYear);
                    });
                }
            });
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

        $schoolHistories = $query->paginate($limit)->appends($request->except('page'));

        return view('pages.dashboard.admin.master-data.school-history.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'schoolHistories' => $schoolHistories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $allowedMaxOrder = SchoolHistory::count() + 1;
        return view('pages.dashboard.admin.master-data.school-history.create', [
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
            SchoolHistory::where('order', '>=', $validated['order'])
                ->lockForUpdate()
                ->increment('order');
            SchoolHistory::create($validated);
        });

        return redirect()->route('dashboard.admin.master-data.school-histories.index')->with('success', 'School History created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolHistory $schoolHistory): View
    {
        return view('pages.dashboard.admin.master-data.school-history.show', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'schoolHistory' => $schoolHistory,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolHistory $schoolHistory): View
    {
        $allowedMaxOrder = SchoolHistory::count();
        return view('pages.dashboard.admin.master-data.school-history.edit', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'allowedMaxOrder' => $allowedMaxOrder,
            'schoolHistory' => $schoolHistory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, SchoolHistory $schoolHistory): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $schoolHistory) {
            $schoolHistory = SchoolHistory::where('id', $schoolHistory->id)
                ->lockForUpdate()
                ->first();
            if ($validated['order'] != $schoolHistory->order) {
                if ($validated['order'] < $schoolHistory->order) {
                    SchoolHistory::where('order', '>=', $validated['order'])
                        ->where('order', '<', $schoolHistory->order)
                        ->lockForUpdate()
                        ->increment('order');
                } else {
                    SchoolHistory::where('order', '>', $schoolHistory->order)
                        ->where('order', '<=', $validated['order'])
                        ->lockForUpdate()
                        ->decrement('order');
                }
            }
            $schoolHistory->update($validated);
        });

        return redirect()->route('dashboard.admin.master-data.school-histories.index')->with('success', 'School History updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolHistory $schoolHistory)
    {
        //
    }
}
