<?php

namespace App\Http\Controllers\Gallery;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\Gallery\Group;

// Requests
use App\Http\Requests\Gallery\Group\IndexRequest;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): View
    {
        $validated = $request->validated();
        $limit = $validated['limit'] ?? 10;

        $query = Group::query()->orderBy('created_at', 'desc');

        if (isset($validated['title'])) {
            $query->where('title', 'ILIKE', '%' . $validated['title'] . '%');
        }
        if (isset($validated['slug'])) {
            $query->where('slug', 'ILIKE', '%' . $validated['slug'] . '%');
        }
        if (isset($validated['description'])) {
            $query->where('description', 'ILIKE', '%' . $validated['description'] . '%');
        }
        if (isset($validated['start_date'])) {
            $query->where('created_at', '>=', Carbon::parse($validated['start_date'])->startOfDay());
        }
        if (isset($validated['end_date'])) {
            $query->where('created_at', '<=', Carbon::parse($validated['end_date'])->endOfDay());
        }

        $groups = $query->paginate($limit)->appends($request->except('page'));

        return view('pages.dashboard.admin.gallery.group.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'groups' => $groups,
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
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }
}
