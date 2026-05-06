<?php

namespace App\Http\Controllers\MasterData;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\MasterData\User;
use App\Models\MasterData\Teacher;

// Requests
use App\Http\Requests\MasterData\User\IndexRequest;
use App\Http\Requests\MasterData\User\StoreRequest;
use App\Http\Requests\MasterData\User\UpdateRequest;

// Enums
use App\Enums\RoleEnum;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): View
    {
        $validated = $request->validated();
        $limit = $validated['limit'] ?? 10;

        $query = User::query()->orderBy('created_at', 'desc');

        if (isset($validated['email'])) {
            $query->where('email', 'ILIKE', '%' . $validated['email'] . '%');
        }
        if (isset($validated['role'])) {
            $query->where('role', $validated['role']);
        }
        if (isset($validated['start_date'])) {
            $query->where('created_at', '>=', Carbon::parse($validated['start_date'])->startOfDay());
        }
        if (isset($validated['end_date'])) {
            $query->where('created_at', '<=', Carbon::parse($validated['end_date'])->endOfDay());
        }

        $users = $query->paginate($limit)->appends($request->except('page'));

        return view('pages.dashboard.admin.master-data.user.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $teachers = Teacher::whereDoesntHave('user')->orderBy('name')->get();
        return view('pages.dashboard.admin.master-data.user.create', [
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

        DB::transaction(function () use ($validated) {
            $user = User::create($validated);

            if ($validated['role'] === RoleEnum::TEACHER->value) {
                Teacher::where('id', $validated['teacher_id'])->update(['user_id' => $user->id]);
            }
        });

        return redirect()->route('dashboard.admin.master-data.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('pages.dashboard.admin.master-data.user.show', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'user' => $user->load(['teacher']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $teachers = Teacher::whereDoesntHave('user')->orWhere('id', $user->teacher?->id)->orderBy('name')->get();

        return view('pages.dashboard.admin.master-data.user.edit', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'user' => $user->load(['teacher']),
            'teachers' => $teachers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        DB::transaction(function () use ($user, $validated) {
            if ($user->role === RoleEnum::TEACHER) {
                if ($validated['role'] !== RoleEnum::TEACHER->value || $user->teacher?->id != $validated['teacher_id']) {
                    Teacher::where('user_id', $user->id)->update(['user_id' => null]);
                }
            }

            $user->update($validated);

            if ($validated['role'] === RoleEnum::TEACHER->value) {
                Teacher::where('id', $validated['teacher_id'])->update(['user_id' => $user->id]);
            }
        });

        return redirect()->route('dashboard.admin.master-data.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        DB::transaction(function () use ($user) {
            if ($user->role === RoleEnum::TEACHER) {
                $user->teacher()->update(['user_id' => null]);
            }

            $user->delete();
        });

        return redirect()->route('dashboard.admin.master-data.users.index')->with('success', 'User deleted successfully.');
    }
}
