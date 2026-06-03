@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumb')
<nav class="breadcrumb" aria-label="Breadcrumb">
    <span style="color:var(--text);font-weight:600;font-size:.9375rem">Dashboard</span>
</nav>
@endsection

@section('content')

@php
    $projectCount   = \App\Models\Project::count();
    $recentProjects = \App\Models\Project::latest()->take(5)->get();
    $messageCount   = \App\Models\Message::count();
    $unreadCount    = \App\Models\Message::unread()->count();
    $completedCount = \App\Models\Project::where('status', 'completed')->count();
    $ongoingCount   = \App\Models\Project::where('status', 'ongoing')->count();
    $plannedCount   = \App\Models\Project::where('status', 'planned')->count();
@endphp

{{-- ===== WELCOME BANNER ===== --}}
<div class="a-card animate-fade-in-up" style="padding:1.75rem;margin-bottom:1.5rem;background:linear-gradient(135deg, var(--p) 0%, var(--p-dark) 100%);border:none;overflow:hidden;position:relative">

    {{-- Decorative circles --}}
    <div style="position:absolute;right:-30px;top:-30px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,.08)"></div>
    <div style="position:absolute;right:60px;bottom:-40px;width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,.06)"></div>

    <div style="position:relative;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap">
        <div>
            <div style="color:rgba(255,255,255,.75);font-size:.8125rem;font-weight:500;margin-bottom:.375rem;display:flex;align-items:center;gap:.375rem">
                <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>
                {{ now()->format('l, F j, Y') }}
            </div>
            <h1 style="color:#fff;font-size:1.5rem;font-weight:700;line-height:1.2;margin-bottom:.375rem">
                Welcome back, {{ Auth::user()->name ?? 'Admin' }} 👋
            </h1>
            <p style="color:rgba(255,255,255,.75);font-size:.875rem">
                Here's an overview of your portfolio panel.
            </p>
        </div>
        <a href="{{ route('admin.projects.create') }}"
           style="display:inline-flex;align-items:center;gap:.5rem;background:rgba(255,255,255,.18);color:#fff;padding:.625rem 1.25rem;border-radius:var(--r-sm);font-size:.875rem;font-weight:500;text-decoration:none;border:1px solid rgba(255,255,255,.25);transition:background .2s,transform .2s;backdrop-filter:blur(6px);flex-shrink:0"
           onmouseover="this.style.background='rgba(255,255,255,.28)';this.style.transform='translateY(-1px)'"
           onmouseout="this.style.background='rgba(255,255,255,.18)';this.style.transform=''"
        >
            <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            New Project
        </a>
    </div>
</div>

{{-- ===== STATS GRID ===== --}}
<div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin-bottom:1.75rem">

    {{-- Total Projects --}}
    <div class="stat-card animate-fade-in-up stagger-1">
        <div class="stat-icon" style="background:var(--p-50);color:var(--p)">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $projectCount }}</div>
            <div class="stat-label">Total Projects</div>
        </div>
    </div>

    {{-- Completed --}}
    <div class="stat-card animate-fade-in-up stagger-2">
        <div class="stat-icon" style="background:#dcfce7;color:#16a34a">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $completedCount }}</div>
            <div class="stat-label">Completed</div>
        </div>
    </div>

    {{-- Ongoing --}}
    <div class="stat-card animate-fade-in-up stagger-3">
        <div class="stat-icon" style="background:#dbeafe;color:#1d4ed8">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $ongoingCount }}</div>
            <div class="stat-label">Ongoing</div>
        </div>
    </div>

    {{-- Planned --}}
    <div class="stat-card animate-fade-in-up stagger-4">
        <div class="stat-icon" style="background:#fef9c3;color:#a16207">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $plannedCount }}</div>
            <div class="stat-label">Planned</div>
        </div>
    </div>

    {{-- Messages --}}
    <div class="stat-card animate-fade-in-up stagger-5">
        <div class="stat-icon" style="background:#fef3c7;color:#d97706">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <a href="{{ route('admin.messages.index') }}" style="text-decoration:none;color:inherit">
                <div class="stat-val">{{ $messageCount }}</div>
                <div class="stat-label">
                    Messages
                    @if($unreadCount > 0)
                        <span style="background:#6366f1;color:#fff;font-size:.65rem;font-weight:700;padding:.1rem .4rem;border-radius:999px;margin-left:4px">{{ $unreadCount }} new</span>
                    @endif
                </div>
            </a>
        </div>
    </div>

    {{-- Last Updated --}}
    <div class="stat-card animate-fade-in-up stagger-5">
        <div class="stat-icon" style="background:#ede9fe;color:#7c3aed">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="stat-val" style="font-size:1rem;margin-bottom:.3rem">
                {{ \App\Models\Project::latest()->first()?->updated_at?->diffForHumans() ?? 'No data' }}
            </div>
            <div class="stat-label">Last Update</div>
        </div>
    </div>

</div>

{{-- ===== MAIN GRID: Recent Projects + Quick Actions ===== --}}
<div class="grid" style="grid-template-columns:1fr minmax(0, 320px);gap:1.5rem;align-items:start" id="dashboard-grid">

    {{-- ---- Recent Projects Table ---- --}}
    <div class="animate-fade-in-up stagger-2">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;gap:1rem;flex-wrap:wrap">
            <div>
                <h2 style="font-size:1.0625rem;font-weight:600;color:var(--text)">Recent Projects</h2>
                <p style="font-size:.8125rem;color:var(--textM);margin-top:.125rem">Latest 5 portfolio projects</p>
            </div>
            <a href="{{ route('admin.projects.index') }}" class="a-btn a-btn-ghost" style="font-size:.8125rem">
                View all
                <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if($recentProjects->count())
            <div class="a-table-wrap">
                <table class="a-table">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th class="hidden sm:table-cell">Status</th>
                            <th class="hidden sm:table-cell">Added</th>
                            <th style="text-align:right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentProjects as $project)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:.75rem">
                                    {{-- Thumbnail --}}
                                    @if(!empty($project->image))
                                        <img src="{{ $project->image }}"
                                             alt="{{ $project->title }}"
                                             style="width:42px;height:42px;object-fit:cover;border-radius:var(--r-xs);flex-shrink:0;border:1px solid var(--border)"
                                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                        <div style="display:none;width:42px;height:42px;border-radius:var(--r-xs);background:var(--surface2);border:1px solid var(--border);align-items:center;justify-content:center;flex-shrink:0">
                                            <svg style="width:18px;height:18px;color:var(--textL)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div style="width:42px;height:42px;border-radius:var(--r-xs);background:var(--p-50);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--p)">
                                            <svg style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div style="font-weight:500;color:var(--text);font-size:.875rem">
                                            {{ \Illuminate\Support\Str::limit($project->title, 32) }}
                                        </div>
                                        <div style="font-size:.75rem;color:var(--textM);margin-top:.125rem">
                                            {{ \Illuminate\Support\Str::limit($project->description, 48) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden sm:table-cell">
                                @php
                                    $sm = ['completed'=>['Completed','#dcfce7','#15803d'],'ongoing'=>['Ongoing','#dbeafe','#1d4ed8'],'planned'=>['Planned','#fef9c3','#a16207']];
                                    [$sl,$sb,$sc] = $sm[$project->status ?? 'completed'] ?? $sm['completed'];
                                @endphp
                                <span style="font-size:.6875rem;font-weight:600;padding:.2rem .6rem;border-radius:20px;background:{{ $sb }};color:{{ $sc }};white-space:nowrap">
                                    {{ $sl }}
                                </span>
                            </td>
                            <td class="hidden sm:table-cell">
                                <span style="font-size:.8125rem;color:var(--textM)">
                                    {{ $project->created_at->format('M d, Y') }}
                                </span>
                            </td>
                            <td style="text-align:right">
                                <div style="display:flex;justify-content:flex-end;gap:.375rem">
                                    <a href="{{ route('admin.projects.edit', $project) }}"
                                       class="a-btn a-btn-ghost"
                                       style="padding:.375rem .625rem;font-size:.8125rem"
                                       title="Edit project">
                                        <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @if(!empty($project->slug))
                                    <a href="{{ route('projects.show', $project->slug) }}"
                                       target="_blank"
                                       class="a-btn a-btn-ghost"
                                       style="padding:.375rem .625rem;font-size:.8125rem"
                                       title="View project">
                                        <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg style="width:28px;height:28px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
                <h3 style="font-size:1rem;font-weight:600;color:var(--text);margin-bottom:.375rem">No projects yet</h3>
                <p style="font-size:.875rem;color:var(--textM);margin-bottom:1.25rem">Create your first project to showcase your work.</p>
                <a href="{{ route('admin.projects.create') }}" class="a-btn a-btn-primary">
                    <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add First Project
                </a>
            </div>
        @endif
    </div>

    {{-- ---- Right Column: Quick Actions + Tips ---- --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem">

        {{-- Quick Actions --}}
        <div class="a-card animate-fade-in-up stagger-3" style="padding:1.25rem">
            <h3 style="font-size:.9375rem;font-weight:600;color:var(--text);margin-bottom:1rem;display:flex;align-items:center;gap:.5rem">
                <svg style="width:18px;height:18px;color:var(--p)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Quick Actions
            </h3>
            <div style="display:flex;flex-direction:column;gap:.625rem">
                <a href="{{ route('admin.projects.create') }}" class="a-btn a-btn-primary" style="justify-content:center;width:100%">
                    <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add New Project
                </a>
                <a href="{{ route('admin.projects.index') }}" class="a-btn a-btn-ghost" style="justify-content:center;width:100%">
                    <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    Manage Projects
                </a>
                <a href="{{ route('home') }}" target="_blank" class="a-btn a-btn-ghost" style="justify-content:center;width:100%">
                    <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    View Portfolio
                </a>
                <a href="{{ route('resume.download') }}" class="a-btn a-btn-ghost" style="justify-content:center;width:100%">
                    <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download Resume
                </a>
            </div>
        </div>

        {{-- Theme Tip Card --}}
        <div class="a-card animate-fade-in-up stagger-4"
             style="padding:1.25rem;background:linear-gradient(135deg, var(--p-50) 0%, var(--surface) 100%);border-color:var(--p-100)">
            <div style="display:flex;align-items:flex-start;gap:.75rem">
                <div style="width:36px;height:36px;border-radius:var(--r-sm);background:var(--p-100);display:flex;align-items:center;justify-content:center;color:var(--p);flex-shrink:0">
                    <svg style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                    </svg>
                </div>
                <div>
                    <div style="font-size:.875rem;font-weight:600;color:var(--text);margin-bottom:.25rem">Theme Customizer</div>
                    <div style="font-size:.8125rem;color:var(--textM);line-height:1.55">
                        Click the palette icon in the top-right to switch between 8 themes, dark/light mode, and more.
                    </div>
                    <button
                        @click="$store.adm.openCustomizer()"
                        class="a-btn a-btn-primary"
                        style="margin-top:.875rem;font-size:.8125rem;padding:.4375rem .875rem"
                    >
                        Open Customizer
                    </button>
                </div>
            </div>
        </div>

    </div>

</div>

{{-- Responsive fix for narrow screens --}}
<style>
@media (max-width: 860px) {
    #dashboard-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

@endsection
