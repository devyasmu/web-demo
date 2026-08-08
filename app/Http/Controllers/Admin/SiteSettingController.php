<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siteSetting = SiteSetting::first();
        return view('admin.site-settings.index', compact('siteSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SiteSetting $siteSetting)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:512',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'youtube' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            // Theme colors validation
            'primary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'accent_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'header_bg_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'footer_bg_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'body_bg_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'header_text_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'footer_text_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'body_text_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'button_primary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'button_primary_hover' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'button_secondary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'button_secondary_hover' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'link_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'link_hover_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'card_bg_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'card_border_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'card_shadow_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'admin_sidebar_bg' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'admin_sidebar_text' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'admin_sidebar_hover' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'admin_header_bg' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'admin_header_text' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            // Transparency validation
            'navbar_transparency' => 'nullable|integer|min:0|max:100',
            'header_transparency' => 'nullable|integer|min:0|max:100',
            'footer_transparency' => 'nullable|integer|min:0|max:100',
            'enable_blur_effect' => 'nullable|boolean',
            // Card button colors validation
            'card_button_bg' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'card_button_text' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'card_button_border' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'card_button_hover_bg' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'card_button_hover_text' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'card_button_hover_border' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            // Detailed color validation
            'section_bg_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'section_text_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'button_text_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'button_outline_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'link_text_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'badge_bg_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'badge_text_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            // Footer color settings
            'footer_link_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'footer_link_hover_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'footer_border_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'footer_social_bg_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'footer_social_hover_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        // Debug: Log the request data
        \Log::info('Site Settings Update Request:', $request->all());
        
        // Handle file uploads
        $data = $request->all();
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($siteSetting->logo && \Storage::exists($siteSetting->logo)) {
                \Storage::delete($siteSetting->logo);
            }
            
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }
        
        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if ($siteSetting->favicon && \Storage::exists($siteSetting->favicon)) {
                \Storage::delete($siteSetting->favicon);
            }
            
            $faviconPath = $request->file('favicon')->store('favicons', 'public');
            $data['favicon'] = $faviconPath;
        }
        
        $siteSetting->update($data);

        return redirect()->route('admin.site-settings.index')
            ->with('success', 'Pengaturan website berhasil diperbarui.');
    }

    /**
     * Reset theme to default colors
     */
    public function resetTheme()
    {
        $siteSetting = SiteSetting::first();
        
        $defaultColors = [
            'primary_color' => '#007bff',
            'secondary_color' => '#6c757d',
            'accent_color' => '#28a745',
            'header_bg_color' => '#ffffff',
            'footer_bg_color' => '#343a40',
            'body_bg_color' => '#f8f9fa',
            'header_text_color' => '#000000',
            'footer_text_color' => '#ffffff',
            'body_text_color' => '#333333',
            'button_primary_color' => '#007bff',
            'button_primary_hover' => '#0056b3',
            'button_secondary_color' => '#6c757d',
            'button_secondary_hover' => '#545b62',
            'link_color' => '#007bff',
            'link_hover_color' => '#0056b3',
            'card_bg_color' => '#ffffff',
            'card_border_color' => '#dee2e6',
            'card_shadow_color' => '#000000',
            'admin_sidebar_bg' => '#343a40',
            'admin_sidebar_text' => '#ffffff',
            'admin_sidebar_hover' => '#495057',
            'admin_header_bg' => '#ffffff',
            'admin_header_text' => '#333333',
        ];

        $siteSetting->update($defaultColors);

        return redirect()->route('admin.site-settings.index')
            ->with('success', 'Tema berhasil direset ke pengaturan default.');
    }

    /**
     * Ubah password admin yang sedang login.
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini salah.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.site-settings.index')
                ->withErrors($validator)
                ->with('active_tab', 'password')
                ->withInput();
        }

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('admin.site-settings.index')
            ->with('success', 'Password berhasil diubah.')
            ->with('active_tab', 'password');
    }
}
