<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::instance();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name'    => 'required|string|max:100',
            'hero_title'   => 'required|string|max:150',
            'hero_subtitle'=> 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'github_url'   => 'nullable|url|max:500',
            'linkedin_url' => 'nullable|url|max:500',
            'resume'       => 'nullable|file|mimes:pdf|max:5120',
            'profile_photo'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $settings = Setting::instance();

        // Handle resume upload — replace existing file in public/
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $file->move(public_path(), 'resume.pdf');
            $validated['resume'] = 'resume.pdf';
        } else {
            unset($validated['resume']);
        }

        // Handle profile photo — store in public storage
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if it exists in storage
            if ($settings->profile_photo && Storage::disk('public')->exists($settings->profile_photo)) {
                Storage::disk('public')->delete($settings->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile', 'public');
            $validated['profile_photo'] = $path;
        } else {
            unset($validated['profile_photo']);
        }

        $settings->update($validated);

        return back()->with('success', 'Settings saved successfully.');
    }
}
