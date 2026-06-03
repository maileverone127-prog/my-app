@extends('layouts.admin')

@section('title', 'Backup & Restore')

@section('breadcrumb')
<nav class="breadcrumb" aria-label="Breadcrumb">
    <span style="color:var(--text);font-weight:600;font-size:.9375rem">Backup & Restore</span>
</nav>
@endsection

@section('content')

{{-- ===== ALERTS ===== --}}
@if (session('success'))
    <div style="background:#dcfce7;color:#15803d;border:1px solid #86efac;border-radius:var(--r-sm);padding:.875rem 1rem;margin-bottom:1.25rem;display:flex;align-items:flex-start;gap:.625rem">
        <svg style="width:18px;height:18px;flex-shrink:0;margin-top:1px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div>
            <p style="font-weight:600;font-size:.875rem">{{ session('success') }}</p>
            @if(session('import_errors'))
                <ul style="margin-top:.375rem;padding-left:1rem;font-size:.8125rem;list-style:disc">
                    @foreach(session('import_errors') as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endif

@if ($errors->any())
    <div style="background:#fee2e2;color:#dc2626;border:1px solid #fca5a5;border-radius:var(--r-sm);padding:.875rem 1rem;margin-bottom:1.25rem;font-size:.875rem">
        {{ $errors->first() }}
    </div>
@endif

{{-- ===== HEADER ===== --}}
<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem">
    <div>
        <h2 style="font-size:1.25rem;font-weight:700;color:var(--text)">Backup & Restore</h2>
        <p style="font-size:.875rem;color:var(--text-muted);margin-top:.25rem">Export your projects as JSON. Import them on any new deployment.</p>
    </div>
    <a href="{{ route('admin.backup.export.all') }}"
       style="display:inline-flex;align-items:center;gap:.5rem;background:var(--p);color:#fff;padding:.625rem 1.25rem;border-radius:var(--r-sm);font-size:.875rem;font-weight:500;text-decoration:none;transition:opacity .2s"
       onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
        <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
        Export All ({{ $projects->count() }} projects)
    </a>
</div>

{{-- ===== TWO COLUMN GRID ===== --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.75rem">

    {{-- EXPORT CARD --}}
    <div class="a-card" style="padding:1.5rem">
        <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1rem">
            <div style="width:36px;height:36px;border-radius:var(--r-sm);background:var(--p-50);color:var(--p);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            </div>
            <div>
                <h3 style="font-size:.9375rem;font-weight:600;color:var(--text)">Export Projects</h3>
                <p style="font-size:.8125rem;color:var(--text-muted)">Download a JSON backup file</p>
            </div>
        </div>
        <p style="font-size:.8125rem;color:var(--text-muted);line-height:1.6;margin-bottom:1rem">
            The exported JSON file contains all project data (title, description, links, status). Store it safely — use it to restore on any new server.
        </p>
        <a href="{{ route('admin.backup.export.all') }}"
           style="display:inline-flex;align-items:center;gap:.5rem;background:var(--p);color:#fff;padding:.5rem 1rem;border-radius:var(--r-sm);font-size:.8125rem;font-weight:500;text-decoration:none;transition:opacity .2s"
           onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
            <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Export All Projects
        </a>
    </div>

    {{-- IMPORT CARD --}}
    <div class="a-card" style="padding:1.5rem">
        <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1rem">
            <div style="width:36px;height:36px;border-radius:var(--r-sm);background:#dcfce7;color:#16a34a;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12"/></svg>
            </div>
            <div>
                <h3 style="font-size:.9375rem;font-weight:600;color:var(--text)">Import Projects</h3>
                <p style="font-size:.8125rem;color:var(--text-muted)">Restore from a JSON backup file</p>
            </div>
        </div>
        <p style="font-size:.8125rem;color:var(--text-muted);line-height:1.6;margin-bottom:1rem">
            Upload a previously exported JSON backup. Projects that already exist (by title) will be skipped automatically.
        </p>
        <form action="{{ route('admin.backup.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display:flex;gap:.625rem;align-items:center;flex-wrap:wrap">
                <label style="display:inline-flex;align-items:center;gap:.5rem;background:var(--bg-2);border:1px solid var(--border);padding:.5rem 1rem;border-radius:var(--r-sm);font-size:.8125rem;cursor:pointer;transition:border-color .2s"
                       onmouseover="this.style.borderColor='var(--p)'" onmouseout="this.style.borderColor='var(--border)'">
                    <svg style="width:14px;height:14px;color:var(--text-muted)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    <span id="file-label" style="color:var(--text-muted)">Choose .json file</span>
                    <input type="file" name="backup_file" accept=".json" required style="display:none"
                           onchange="document.getElementById('file-label').textContent = this.files[0]?.name || 'Choose .json file'">
                </label>
                <button type="submit"
                        style="display:inline-flex;align-items:center;gap:.5rem;background:#16a34a;color:#fff;padding:.5rem 1rem;border-radius:var(--r-sm);font-size:.8125rem;font-weight:500;border:none;cursor:pointer;transition:opacity .2s"
                        onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                    <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12"/></svg>
                    Import
                </button>
            </div>
        </form>
    </div>

</div>

{{-- ===== PER-PROJECT TABLE ===== --}}
<div class="a-card" style="padding:1.5rem">
    <h3 style="font-size:.9375rem;font-weight:600;color:var(--text);margin-bottom:1rem">Export Individual Project</h3>

    @if($projects->isEmpty())
        <p style="color:var(--text-muted);font-size:.875rem;text-align:center;padding:2rem 0">No projects yet.</p>
    @else
        <div style="overflow-x:auto">
            <table style="width:100%;border-collapse:collapse;font-size:.875rem">
                <thead>
                    <tr style="border-bottom:1px solid var(--border)">
                        <th style="text-align:left;padding:.625rem .75rem;color:var(--text-muted);font-weight:500;font-size:.8125rem">#</th>
                        <th style="text-align:left;padding:.625rem .75rem;color:var(--text-muted);font-weight:500;font-size:.8125rem">Title</th>
                        <th style="text-align:left;padding:.625rem .75rem;color:var(--text-muted);font-weight:500;font-size:.8125rem">Status</th>
                        <th style="text-align:left;padding:.625rem .75rem;color:var(--text-muted);font-weight:500;font-size:.8125rem">Created</th>
                        <th style="text-align:right;padding:.625rem .75rem;color:var(--text-muted);font-weight:500;font-size:.8125rem">Export</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $i => $project)
                    <tr style="border-bottom:1px solid var(--border);transition:background .15s" onmouseover="this.style.background='var(--bg-2)'" onmouseout="this.style.background=''">
                        <td style="padding:.75rem;color:var(--text-muted)">{{ $i + 1 }}</td>
                        <td style="padding:.75rem;font-weight:500;color:var(--text)">{{ $project->title }}</td>
                        <td style="padding:.75rem">
                            @php
                                $badge = match($project->status) {
                                    'completed' => ['bg'=>'#dcfce7','color'=>'#15803d','label'=>'Completed'],
                                    'ongoing'   => ['bg'=>'#dbeafe','color'=>'#1d4ed8','label'=>'Ongoing'],
                                    default     => ['bg'=>'#fef9c3','color'=>'#a16207','label'=>'Planned'],
                                };
                            @endphp
                            <span style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};padding:.25rem .625rem;border-radius:999px;font-size:.75rem;font-weight:500">
                                {{ $badge['label'] }}
                            </span>
                        </td>
                        <td style="padding:.75rem;color:var(--text-muted)">{{ $project->created_at?->format('d M Y') }}</td>
                        <td style="padding:.75rem;text-align:right">
                            <a href="{{ route('admin.backup.export.single', $project) }}"
                               style="display:inline-flex;align-items:center;gap:.375rem;background:var(--p-50);color:var(--p);padding:.375rem .75rem;border-radius:var(--r-sm);font-size:.8125rem;font-weight:500;text-decoration:none;transition:background .2s"
                               onmouseover="this.style.background='var(--p)';this.style.color='#fff'" onmouseout="this.style.background='var(--p-50)';this.style.color='var(--p)'">
                                <svg style="width:13px;height:13px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Export
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
