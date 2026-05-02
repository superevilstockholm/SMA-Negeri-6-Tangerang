<?php

namespace App\Http\Controllers\MasterData;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\MasterData\Classroom;

// Requests
use App\Http\Requests\MasterData\Classroom\IndexRequest;
use App\Http\Requests\MasterData\Classroom\StoreRequest;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): View
    {
        $validated = $request->validated();
        $limit = $validated['limit'] ?? 10;

        $query = Classroom::query()->orderBy('created_at', 'asc');

        if (isset($validated['name'])) {
            $query->where('name', 'ILIKE', '%' . $validated['name'] . '%');
        }
        if (isset($validated['start_date'])) {
            $query->where('created_at', '>=', Carbon::parse($validated['start_date'])->startOfDay());
        }
        if (isset($validated['end_date'])) {
            $query->where('created_at', '<=', Carbon::parse($validated['end_date'])->endOfDay());
        }

        $classrooms = $query->paginate($limit)->appends($request->except('page'));

        return view('pages.dashboard.admin.master-data.classroom.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'classrooms' => $classrooms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.dashboard.admin.master-data.classroom.create', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Classroom::create($validated);

        return redirect()->route('dashboard.admin.master-data.classrooms.index')->with('success', 'Classroom created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom): View
    {
        return view('pages.dashboard.admin.master-data.classroom.show', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'classroom' => $classroom,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        //
    }
}
