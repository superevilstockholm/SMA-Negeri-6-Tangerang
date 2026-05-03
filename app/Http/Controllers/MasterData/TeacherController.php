<?php

namespace App\Http\Controllers\MasterData;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\MasterData\Teacher;

// Requests
use App\Http\Requests\MasterData\Teacher\IndexRequest;
use App\Http\Requests\MasterData\Teacher\StoreRequest;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): View
    {
        $validated = $request->validated();
        $limit = $validated['limit'] ?? 10;

        $query = Teacher::query()->orderBy('created_at', 'desc');

        if (isset($validated['name'])) {
            $query->where('name', 'ILIKE', '%' . $validated['name'] . '%');
        }
        if (isset($validated['nip'])) {
            $query->where('nip', 'ILIKE', '%' . $validated['nip'] . '%');
        }
        if (isset($validated['start_dob'])) {
            $query->where('dob', '>=', $validated['start_dob']);
        }
        if (isset($validated['end_dob'])) {
            $query->where('dob', '<=', $validated['end_dob']);
        }
        if (isset($validated['gender'])) {
            $query->where('gender', $validated['gender']);
        }
        if (isset($validated['has_user'])) {
            $validated['has_user']
                ? $query->whereNotNull('user_id')
                : $query->whereNull('user_id');
        }
        if (isset($validated['start_date'])) {
            $query->where('created_at', '>=', Carbon::parse($validated['start_date'])->startOfDay());
        }
        if (isset($validated['end_date'])) {
            $query->where('created_at', '<=', Carbon::parse($validated['end_date'])->endOfDay());
        }

        $teachers = $query->paginate($limit)->appends($request->except('page'));

        return view('pages.dashboard.admin.master-data.teacher.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'teachers' => $teachers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.dashboard.admin.master-data.teacher.create', [
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

        if ($request->hasFile('profile_file')) {
            $validated['photo_path'] = $request->file('profile_file')->store('master-data/teachers/profile', 'public');
        }

        Teacher::create($validated);

        return redirect()->route('dashboard.admin.master-data.teachers.index')->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        //
    }
}
