@extends('layouts.admin')
@use('Illuminate\Support\Facades\Storage')

@section('title', 'Settings')

@section('breadcrumb')
<nav class="breadcrumb" aria-label="Breadcrumb">
    <span style="color:var(--text);font-weight:600;font-size:.9375rem">Settings</span>
</nav>
@endsection

@section('content')

@if(session('success'))
    <div style="background:#dcfce7;color:#15803d;border:1px solid #86efac;border-radius:var(--r-sm);padding:.875rem 1rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:.5rem;font-size:.875rem">
        <svg style="width:16px;height:16px;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background:#fee2e2;color:#dc2626;border:1px solid #fca5a5;border-radius:var(--r-sm);padding:.875rem 1rem;margin-bottom:1.5rem;font-size:.875rem">
        <ul style="margin:0;padding-left:1.25rem">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div style="display:grid;gap:1.25rem;max-width:800px">

        {{-- ===== PORTFOLIO INFORMATION ===== --}}
        <div class="a-card" style="padding:1.5rem">
            <h3 style="font-size:.9375rem;font-weight:700;color:var(--text);margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:.5rem">
                <svg style="width:16px;height:16px;color:var(--p)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Portfolio Information
            </h3>

            <div style="display:grid;gap:1rem">
                <div>
                    <label class="a-label" for="site_name">Site Name</label>
                    <input type="text" id="site_name" name="site_name"
                           value="{{ old('site_name', $settings->site_name) }}"
                           class="a-input" placeholder="Kushal.dev" required>
                    <p style="font-size:.75rem;color:var(--text-muted);margin-top:.375rem">Shown in the navbar logo and browser tab.</p>
                </div>

                <div>
                    <label class="a-label" for="hero_title">Hero Title</label>
                    <input type="text" id="hero_title" name="hero_title"
                           value="{{ old('hero_title', $settings->hero_title) }}"
                           class="a-input" placeholder="Kushal Ghimire" required>
                    <p style="font-size:.75rem;color:var(--text-muted);margin-top:.375rem">Large heading displayed in the hero section.</p>
                </div>

                <div>
                    <label class="a-label" for="hero_subtitle">Hero Subtitle</label>
                    <input type="text" id="hero_subtitle" name="hero_subtitle"
                           value="{{ old('hero_subtitle', $settings->hero_subtitle) }}"
                           class="a-input" placeholder="Frontend Developer · Backend Specialist" required>
                    <p style="font-size:.75rem;color:var(--text-muted);margin-top:.375rem">Roles shown below the hero title. Use · as separator.</p>
                </div>
            </div>
        </div>

        {{-- ===== CONTACT INFORMATION ===== --}}
        <div class="a-card" style="padding:1.5rem">
            <h3 style="font-size:.9375rem;font-weight:700;color:var(--text);margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:.5rem">
                <svg style="width:16px;height:16px;color:var(--p)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Contact Information
            </h3>
            <div>
                <label class="a-label" for="email">Email Address</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email', $settings->email) }}"
                       class="a-input" placeholder="you@example.com" required>
                <p style="font-size:.75rem;color:var(--text-muted);margin-top:.375rem">Shown on the portfolio and used as the mailto link.</p>
            </div>
        </div>

        {{-- ===== SOCIAL LINKS ===== --}}
        <div class="a-card" style="padding:1.5rem">
            <h3 style="font-size:.9375rem;font-weight:700;color:var(--text);margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:.5rem">
                <svg style="width:16px;height:16px;color:var(--p)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                Social Links
            </h3>
            <div style="display:grid;gap:1rem">
                <div>
                    <label class="a-label" for="github_url">GitHub URL</label>
                    <input type="url" id="github_url" name="github_url"
                           value="{{ old('github_url', $settings->github_url) }}"
                           class="a-input" placeholder="https://github.com/username">
                </div>
                <div>
                    <label class="a-label" for="linkedin_url">LinkedIn URL</label>
                    <input type="url" id="linkedin_url" name="linkedin_url"
                           value="{{ old('linkedin_url', $settings->linkedin_url) }}"
                           class="a-input" placeholder="https://linkedin.com/in/username">
                </div>
            </div>
        </div>

        {{-- ===== RESUME ===== --}}
        <div class="a-card" style="padding:1.5rem">
            <h3 style="font-size:.9375rem;font-weight:700;color:var(--text);margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:.5rem">
                <svg style="width:16px;height:16px;color:var(--p)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Resume
            </h3>

            @if(file_exists(public_path('resume.pdf')))
                <div style="display:flex;align-items:center;gap:.75rem;padding:.75rem 1rem;background:var(--bg-2);border:1px solid var(--border);border-radius:var(--r-sm);margin-bottom:1rem">
                    <svg style="width:20px;height:20px;color:#dc2626;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <div style="flex:1;min-width:0">
                        <p style="font-size:.875rem;font-weight:500;color:var(--text);margin:0">resume.pdf</p>
                        <p style="font-size:.75rem;color:var(--text-muted);margin:0">Current resume file</p>
                    </div>
                    <a href="{{ route('resume.download') }}"
                       style="font-size:.8125rem;color:var(--p);text-decoration:none;font-weight:500">Download</a>
                </div>
            @else
                <p style="font-size:.875rem;color:var(--text-muted);margin-bottom:1rem">No resume uploaded yet.</p>
            @endif

            <div>
                <label class="a-label" for="resume">Upload New Resume <span style="font-weight:400;color:var(--text-muted)">(PDF, max 5 MB)</span></label>
                <input type="file" id="resume" name="resume" accept=".pdf"
                       style="display:block;width:100%;font-size:.875rem;color:var(--text);padding:.5rem;border:1px solid var(--border);border-radius:var(--r-sm);background:var(--bg-2);cursor:pointer">
                <p style="font-size:.75rem;color:var(--text-muted);margin-top:.375rem">Replaces the current resume.pdf file.</p>
            </div>
        </div>

        {{-- ===== PROFILE PHOTO ===== --}}
        <div class="a-card" style="padding:1.5rem">
            <h3 style="font-size:.9375rem;font-weight:700;color:var(--text);margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:.5rem">
                <svg style="width:16px;height:16px;color:var(--p)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Profile Photo
            </h3>

            @if($settings->profile_photo && Storage::disk('public')->exists($settings->profile_photo))
                <div style="margin-bottom:1rem">
                    <img src="{{ Storage::url($settings->profile_photo) }}"
                         alt="Profile Photo"
                         style="width:96px;height:96px;border-radius:50%;object-fit:cover;border:3px solid var(--border)">
                </div>
            @else
                <div style="width:96px;height:96px;border-radius:50%;background:var(--bg-2);border:2px dashed var(--border);display:flex;align-items:center;justify-content:center;margin-bottom:1rem">
                    <svg style="width:32px;height:32px;color:var(--text-muted)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            @endif

            <div>
                <label class="a-label" for="profile_photo">Upload Photo <span style="font-weight:400;color:var(--text-muted)">(JPG, PNG, WebP — max 3 MB)</span></label>
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                       style="display:block;width:100%;font-size:.875rem;color:var(--text);padding:.5rem;border:1px solid var(--border);border-radius:var(--r-sm);background:var(--bg-2);cursor:pointer">
                <p style="font-size:.75rem;color:var(--text-muted);margin-top:.375rem">Replaces the existing photo. Shown in the hero section.</p>
            </div>
        </div>

        {{-- ===== SAVE ===== --}}
        <div style="display:flex;justify-content:flex-end">
            <button type="submit"
                    style="display:inline-flex;align-items:center;gap:.5rem;background:var(--p);color:#fff;padding:.75rem 1.75rem;border-radius:var(--r-sm);font-size:.875rem;font-weight:600;border:none;cursor:pointer;transition:opacity .2s"
                    onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Save Settings
            </button>
        </div>

    </div>
</form>

@endsection
