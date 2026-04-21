<?php

namespace App\Http\Controllers\MasterData;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\MasterData\Vision;

// Requests
use App\Http\Requests\MasterData\Vision\IndexRequest;

class VisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): View
    {
        $validated = $request->validated();
        $limit = $validated['limit'] ?? 10;

        $query = Vision::query();

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

        $visions = $query->paginate($limit)->appends($request->except('page'));

        return view('pages.dashboard.admin.master-data.vision.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'visions' => $visions,
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
    public function show(Vision $vision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vision $vision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vision $vision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vision $vision)
    {
        //
    }
}
