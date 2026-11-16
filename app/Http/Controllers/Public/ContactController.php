<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\SiteSetting;
use App\Models\Menu;
use App\Models\RunningText;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Support\SpamGuard;

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
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100', 'not_regex:~(https?://|www\.|<|>)~i'],
            'email' => 'required|email|max:255',
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'subject' => ['required', 'string', 'min:3', 'max:150', 'not_regex:~(https?://|www\.)~i'],
            'message' => 'required|string|min:10|max:1000',
        ]);

        $successMessage = 'Pesan Anda telah berhasil dikirim. Terima kasih!';

        $spamReason = SpamGuard::check($request, ['name', 'subject', 'message']);
        if ($spamReason !== null) {
            Log::notice('Contact form blocked', ['reason' => $spamReason, 'ip' => $request->ip()]);

            if ($spamReason === 'honeypot') {
                // Bot: pura-pura berhasil, tapi tidak disimpan dan tidak mengirim email.
                return redirect()->back()->with('success', $successMessage);
            }

            return redirect()->back()->withInput()->withErrors([
                'message' => in_array($spamReason, ['too_many_links', 'blocked_word'], true)
                    ? 'Pesan ditolak karena terdeteksi sebagai spam.'
                    : 'Sesi formulir tidak valid. Muat ulang halaman lalu kirim lagi.',
            ]);
        }

        // Hanya field yang tervalidasi; mencegah penyerang mengisi kolom lain seperti is_read.
        $validated = array_map(fn ($value) => is_string($value) ? trim(strip_tags($value)) : $value, $validated);
        $contact = Contact::create($validated);
        
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
            Log::error('Contact email failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', $successMessage);
    }
}
