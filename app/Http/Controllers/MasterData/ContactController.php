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

        $query = Contact::query()->orderBy('created_at', 'desc');

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
        if (isset($validated['start_date'])) {
            $query->where('created_at', '>=', Carbon::parse($validated['start_date'])->startOfDay());
        }
        if (isset($validated['end_date'])) {
            $query->where('created_at', '<=', Carbon::parse($validated['end_date'])->endOfDay());
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
    public function show(Contact $contact): View
    {
        if (!$contact->read_at) {
            $contact->read_at = Carbon::now();
            $contact->save();
        }
        return view('pages.dashboard.admin.master-data.contact.show', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'contact' => $contact,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('dashboard.admin.master-data.contacts.index')->with('success', 'Contact deleted successfully.');
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
