<?php

namespace App\Http\Controllers\MasterData;

use Carbon\Carbon;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\MasterData\Subject;

// Requests
use App\Http\Requests\MasterData\Subject\IndexRequest;
use App\Http\Requests\MasterData\Subject\StoreRequest;
use App\Http\Requests\MasterData\Subject\UpdateRequest;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): View
    {
        $validated = $request->validated();
        $limit = $validated['limit'] ?? 10;

        $query = Subject::query()->orderBy('created_at', 'asc');

        if (isset($validated['name'])) {
            $query->where('name', 'ILIKE', '%' . $validated['name'] . '%');
        }
        if (isset($validated['start_date'])) {
            $query->where('created_at', '>=', Carbon::parse($validated['start_date'])->startOfDay());
        }
        if (isset($validated['end_date'])) {
            $query->where('created_at', '<=', Carbon::parse($validated['end_date'])->endOfDay());
        }

        $subjects = $query->paginate($limit)->appends($request->except('page'));

        return view('pages.dashboard.admin.master-data.subject.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'subjects' => $subjects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.dashboard.admin.master-data.subject.create', [
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

        Subject::create($validated);

        return redirect()->route('dashboard.admin.master-data.subjects.index')->with('success', 'Subject created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject): View
    {
        return view('pages.dashboard.admin.master-data.subject.edit', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'subject' => $subject,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Subject $subject): RedirectResponse
    {
        $validated = $request->validated();

        $subject->update($validated);

        return redirect()->route('dashboard.admin.master-data.subjects.index')->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject): RedirectResponse
    {
        $subject->delete();

        return redirect()->route('dashboard.admin.master-data.subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
