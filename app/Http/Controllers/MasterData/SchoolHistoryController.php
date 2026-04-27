<?php

namespace App\Http\Controllers\MasterData;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\MasterData\SchoolHistory;

// Requests
use App\Http\Requests\MasterData\SchoolHistory\IndexRequest;

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolHistory $schoolHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolHistory $schoolHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolHistory $schoolHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolHistory $schoolHistory)
    {
        //
    }
}
