<?php

namespace App\Http\Controllers\MasterData;

use Carbon\Carbon;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\MasterData\Contact;

// Requests
use App\Http\Requests\MasterData\Contact\IndexRequest;
use App\Http\Requests\MasterData\Contact\AttemptRequest;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): View
    {
        $validated = $request->validated();
        $limit = $validated['limit'] ?? 10;

        $query = Contact::query();

        if (isset($validated['name'])) {
            $query->where('name', 'ILIKE', '%' . $validated['name'] . '%');
        }
        if (isset($validated['email'])) {
            $query->where('email', 'ILIKE', '%' . $validated['email'] . '%');
        }
        if (isset($validated['phone'])) {
            $query->where('phone', 'ILIKE', '%' . $validated['phone'] . '%');
        }
        if (isset($validated['message'])) {
            $query->where('message', 'ILIKE', '%' . $validated['message'] . '%');
        }
        if (isset($validated['startDate'])) {
            $query->where('created_at', '>=', Carbon::parse($validated['startDate'])->startOfDay());
        }
        if (isset($validated['endDate'])) {
            $query->where('created_at', '<=', Carbon::parse($validated['endDate'])->endOfDay());
        }

        $contacts = $query->paginate($limit)->appends($request->except('page'));

        return view('pages.dashboard.admin.master-data.contact.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'contacts' => $contacts,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }

    public function contactUsView(): View
    {
        return view('pages.contact-us');
    }

    public function contactUsAttempt(AttemptRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Contact::create($validated);

        return redirect()->route('contact-us-view')->with('success', 'Your message has been sent!');
    }
}
