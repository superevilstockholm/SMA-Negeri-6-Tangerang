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
        if (isset($validated['start_year']) || isset($validated['end_year'])) {
            $query->where(function ($q) use ($validated) {
                $start_year = $validated['start_year'] ?? null;
                $end_year   = $validated['end_year'] ?? null;
                if ($start_year && $end_year) {
                    $q->where('start_year', '<=', $end_year)
                    ->where(function ($qq) use ($start_year) {
                        $qq->whereNull('end_year')
                            ->orWhere('end_year', '>=', $start_year);
                    });
                } elseif ($start_year) {
                    $q->where(function ($qq) use ($start_year) {
                        $qq->where('start_year', '>=', $start_year)
                        ->orWhere('end_year', '>=', $start_year);
                    });
                } elseif ($end_year) {
                    $q->where(function ($qq) use ($end_year) {
                        $qq->where('start_year', '<=', $end_year)
                        ->orWhere('end_year', '<=', $end_year);
                    });
                }
            });
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
    public function destroy(SchoolHistory $schoolHistory): RedirectResponse
    {
        DB::transaction(function () use ($schoolHistory) {
            $schoolHistory = SchoolHistory::where('id', $schoolHistory->id)
                ->lockForUpdate()
                ->first();
            $deletedOrder = $schoolHistory->order;
            $schoolHistory->delete();
            SchoolHistory::where('order', '>', $deletedOrder)
                ->lockForUpdate()
                ->decrement('order');
        });

        return redirect()->route('dashboard.admin.master-data.school-histories.index')->with('success', 'School History deleted successfully.');
    }
}
