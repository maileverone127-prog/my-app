@extends('layouts.admin')

@section('title', 'Manage Projects')

@section('breadcrumb')
<nav class="breadcrumb" aria-label="Breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep" aria-hidden="true">/</span>
    <span style="color:var(--text);font-weight:600">Projects</span>
</nav>
@endsection

@section('content')

{{-- ===== FLASH MESSAGES ===== --}}
@if(session('success'))
    <div class="a-alert a-alert-success animate-fade-in" style="margin-bottom:1.25rem" role="alert">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="a-alert a-alert-error animate-fade-in" style="margin-bottom:1.25rem" role="alert">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
@endif

{{-- ===== PAGE HEADER ===== --}}
<div class="page-header" style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem">
    <div>
        <h1 class="page-title">Manage Projects</h1>
        <p class="page-subtitle">
            {{ $projects->total() }} project{{ $projects->total() !== 1 ? 's' : '' }} total
        </p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="a-btn a-btn-primary animate-fade-in">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Add New Project
    </a>
</div>

{{-- ===== PROJECTS GRID ===== --}}
@if($projects->count())

    <div class="grid animate-fade-in-up"
         style="grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.25rem;margin-bottom:1.5rem">

        @foreach($projects as $i => $project)
            <div class="proj-card" style="animation-delay:{{ $i * 0.06 }}s">

                {{-- Image --}}
                <div class="proj-card-img">
                    @if(!empty($project->image))
                        <img
                            src="{{ $project->image }}"
                            alt="{{ $project->title }}"
                            loading="lazy"
                            onerror="this.parentElement.innerHTML='<div style=\'width:100%;height:200px;background:var(--surface2);display:flex;align-items:center;justify-content:center;color:var(--textL)\'><svg style=\'width:32px;height:32px\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\' stroke-width=\'1.5\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg></div>'"
                        >
                    @else
                        <div style="width:100%;height:200px;background:var(--p-50);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:.5rem;color:var(--p)">
                            <svg style="width:32px;height:32px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                            </svg>
                            <span style="font-size:.75rem;font-weight:500;opacity:.7">No image</span>
                        </div>
                    @endif

                    {{-- Hover overlay actions --}}
                    <div class="proj-card-overlay" aria-hidden="true">
                        <a href="{{ route('admin.projects.edit', $project) }}"
                           style="display:inline-flex;align-items:center;gap:.375rem;padding:.5rem 1rem;background:white;color:#111;border-radius:var(--r-xs);font-size:.8125rem;font-weight:500;text-decoration:none;transition:background .15s"
                           onmouseover="this.style.background='#f1f5f9'"
                           onmouseout="this.style.background='white'">
                            <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.projects.destroy', $project) }}"
                              method="POST"
                              onsubmit="return confirm('Delete \'{{ addslashes($project->title) }}\' permanently? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="display:inline-flex;align-items:center;gap:.375rem;padding:.5rem 1rem;background:#ef4444;color:white;border:none;border-radius:var(--r-xs);font-size:.8125rem;font-weight:500;cursor:pointer;transition:background .15s"
                                    onmouseover="this.style.background='#dc2626'"
                                    onmouseout="this.style.background='#ef4444'">
                                <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Card body --}}
                <div class="proj-card-body">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.5rem;margin-bottom:.375rem">
                        <h3 class="proj-card-title" style="margin-bottom:0">{{ $project->title }}</h3>
                        @php
                            $statusMap = [
                                'completed' => ['label' => 'Completed', 'bg' => '#dcfce7', 'color' => '#15803d'],
                                'ongoing'   => ['label' => 'Ongoing',   'bg' => '#dbeafe', 'color' => '#1d4ed8'],
                                'planned'   => ['label' => 'Planned',   'bg' => '#fef9c3', 'color' => '#a16207'],
                            ];
                            $s = $statusMap[$project->status ?? 'completed'] ?? $statusMap['completed'];
                        @endphp
                        <span style="flex-shrink:0;font-size:.6875rem;font-weight:600;padding:.2rem .55rem;border-radius:20px;background:{{ $s['bg'] }};color:{{ $s['color'] }};white-space:nowrap">
                            {{ $s['label'] }}
                        </span>
                    </div>
                    <p class="proj-card-desc">
                        {{ \Illuminate\Support\Str::limit($project->description, 85) }}
                    </p>

                    {{-- Footer actions --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:1rem;padding-top:.875rem;border-top:1px solid var(--border)">
                        <div style="display:flex;gap:.375rem">
                            <a href="{{ route('admin.projects.edit', $project) }}"
                               class="a-btn a-btn-ghost"
                               style="padding:.375rem .75rem;font-size:.8125rem"
                               title="Edit project">
                                <svg style="width:13px;height:13px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>

                            @if(!empty($project->slug))
                            <a href="{{ route('projects.show', $project->slug) }}"
                               target="_blank"
                               class="a-btn a-btn-ghost"
                               style="padding:.375rem .75rem;font-size:.8125rem"
                               title="View live project">
                                <svg style="width:13px;height:13px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                View
                            </a>
                            @endif
                        </div>

                        <form action="{{ route('admin.projects.destroy', $project) }}"
                              method="POST"
                              onsubmit="return confirm('Delete \'{{ addslashes($project->title) }}\' permanently?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="a-btn a-btn-danger"
                                    style="padding:.375rem .625rem;font-size:.8125rem"
                                    title="Delete project"
                                    aria-label="Delete {{ $project->title }}">
                                <svg style="width:13px;height:13px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @endforeach

    </div>

    {{-- Pagination --}}
    <div style="margin-top:.5rem">
        {{ $projects->links() }}
    </div>

@else

    {{-- Empty state --}}
    <div class="empty-state animate-fade-in-up">
        <div class="empty-icon">
            <svg style="width:28px;height:28px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
        </div>
        <h3 style="font-size:1.125rem;font-weight:600;color:var(--text);margin-bottom:.5rem">
            No projects yet
        </h3>
        <p style="font-size:.875rem;color:var(--textM);margin-bottom:1.5rem;max-width:360px;margin-left:auto;margin-right:auto">
            Start building your portfolio by creating your first project.
        </p>
        <a href="{{ route('admin.projects.create') }}" class="a-btn a-btn-primary">
            <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Create First Project
        </a>
    </div>

@endif

@endsection
