<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index()
    {
        $siteSettings = SiteSetting::first();
        return view('contact.index', compact('siteSettings'));
    }

    /**
     * Store a newly created contact submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $contact = Contact::create($validated);

        // Send email notification to admin (optional)
        try {
            $siteSettings = SiteSetting::first();
            if ($siteSettings && $siteSettings->email) {
                Mail::send('emails.contact-notification', ['contact' => $contact], function ($message) use ($siteSettings, $contact) {
                    $message->to($siteSettings->email)
                            ->subject('Pesan Baru dari ' . $contact->name . ' - ' . $contact->subject);
                });
            }
        } catch (\Exception $e) {
            // Log error but don't fail the contact submission
            \Log::error('Failed to send contact email: ' . $e->getMessage());
        }

        return redirect()->route('contact.index')
                        ->with('success', 'Pesan Anda telah berhasil dikirim. Kami akan segera menghubungi Anda.');
    }
}
