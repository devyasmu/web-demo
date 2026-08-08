<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\SiteSetting;
use App\Models\Menu;
use App\Models\RunningText;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display the contact form.
     */
    public function index()
    {
        $siteSettings = SiteSetting::first();
        $menus = Menu::active()->ordered()->get();
        $runningTexts = RunningText::active()->ordered()->get();        
        return view('public.contacts.index', compact('siteSettings', "menus", "runningTexts"));
    }
    
    /**
     * Store a newly created contact message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);
        
        $contact = Contact::create($request->all());
        
        // Send email notification to admin
        try {
            $adminEmail = config('mail.from.address');
            if ($adminEmail) {
                Mail::send('emails.contact', ['contact' => $contact], function ($message) use ($contact, $adminEmail) {
                    $message->to($adminEmail)
                            ->subject('Pesan Kontak Baru: ' . $contact->subject);
                });
            }
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Contact email failed: ' . $e->getMessage());
        }
        
        return redirect()->back()->with('success', 'Pesan Anda telah berhasil dikirim. Terima kasih!');
    }
}
