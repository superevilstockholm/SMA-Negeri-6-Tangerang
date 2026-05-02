<?php

namespace App\Http\Controllers\MasterData;

use Carbon\Carbon;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\MasterData\Teacher;
use App\Models\MasterData\Classroom;

// Requests
use App\Http\Requests\MasterData\Classroom\IndexRequest;
use App\Http\Requests\MasterData\Classroom\StoreRequest;
use App\Http\Requests\MasterData\Classroom\UpdateRequest;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): View
    {
        $validated = $request->validated();
        $limit = $validated['limit'] ?? 10;

        $query = Classroom::query()->with(['homeroomTeacher'])->orderBy('created_at', 'asc');

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
        $teachers = Teacher::whereDoesntHave('homeroomClassroom')->orderBy('name')->get();
        return view('pages.dashboard.admin.master-data.classroom.create', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'teachers' => $teachers,
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
            'classroom' => $classroom->load(['homeroomTeacher']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom): View
    {
        $teachers = Teacher::whereDoesntHave('homeroomClassroom')->orWhere('id', $classroom->homeroom_teacher_id)->orderBy('name')->get();
        return view('pages.dashboard.admin.master-data.classroom.edit', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'classroom' => $classroom,
            'teachers' => $teachers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Classroom $classroom): RedirectResponse
    {
        $validated = $request->validated();

        $classroom->update($validated);

        return redirect()->route('dashboard.admin.master-data.classrooms.index')->with('success', 'Classroom updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom): RedirectResponse
    {
        $classroom->delete();

        return redirect()->route('dashboard.admin.master-data.classrooms.index')->with('success', 'Classroom deleted successfully.');
    }
}
