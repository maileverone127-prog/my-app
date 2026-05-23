@extends('layouts.admin')

@section('title', 'Edit Project')

@section('breadcrumb')
<nav class="breadcrumb" aria-label="Breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep" aria-hidden="true">/</span>
    <a href="{{ route('admin.projects.index') }}">Projects</a>
    <span class="breadcrumb-sep" aria-hidden="true">/</span>
    <span style="color:var(--text);font-weight:600">Edit</span>
</nav>
@endsection

@section('content')

@php use Illuminate\Support\Str; @endphp

{{-- ===== PAGE HEADER ===== --}}
<div class="page-header" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem">
    <div>
        <h1 class="page-title">Edit Project</h1>
        <p class="page-subtitle">Update details for: <strong style="color:var(--text)">{{ Str::limit($project->title, 50) }}</strong></p>
    </div>
    <div style="display:flex;gap:.625rem">
        @if(!empty($project->slug))
        <a href="{{ route('projects.show', $project->slug) }}"
           target="_blank"
           class="a-btn a-btn-ghost">
            <svg style="width:15px;height:15px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            View Live
        </a>
        @endif
        <a href="{{ route('admin.projects.index') }}" class="a-btn a-btn-ghost">
            <svg style="width:15px;height:15px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back
        </a>
    </div>
</div>

{{-- ===== FORM GRID ===== --}}
<div class="grid animate-fade-in-up" style="grid-template-columns:1fr minmax(0,340px);gap:1.5rem;align-items:start" id="edit-grid">

    {{-- ---- Main Form ---- --}}
    <div class="a-card" style="padding:1.75rem">

        {{-- Flash success --}}
        @if(session('success'))
            <div class="a-alert a-alert-success" style="margin-bottom:1.5rem" role="alert">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="a-alert a-alert-error" style="margin-bottom:1.5rem" role="alert">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <strong style="display:block;margin-bottom:.25rem">Please fix the following errors:</strong>
                    <ul style="list-style:disc;padding-left:1.25rem;margin:0;font-size:.8125rem">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.projects.update', $project) }}"
              method="POST"
              enctype="multipart/form-data"
              x-data="editForm()"
              @submit="submitting = true"
              novalidate>
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div style="margin-bottom:1.25rem">
                <label for="title" class="a-label">
                    Project Title
                    <span style="color:#ef4444;margin-left:2px" aria-hidden="true">*</span>
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $project->title) }}"
                    required
                    autocomplete="off"
                    placeholder="Project name"
                    class="a-input @error('title') !border-red-400 @enderror"
                >
                @error('title')
                    <div style="color:#ef4444;font-size:.75rem;margin-top:.3rem" role="alert">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div style="margin-bottom:1.25rem">
                <label for="description" class="a-label">
                    Description
                    <span style="color:#ef4444;margin-left:2px" aria-hidden="true">*</span>
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    required
                    placeholder="Describe what the project does..."
                    class="a-input a-textarea @error('description') !border-red-400 @enderror"
                >{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <div style="color:#ef4444;font-size:.75rem;margin-top:.3rem" role="alert">{{ $message }}</div>
                @enderror
            </div>

            {{-- GitHub Link --}}
            <div style="margin-bottom:1.25rem">
                <label for="github_link" class="a-label">GitHub Link</label>
                <div style="position:relative">
                    <div style="position:absolute;left:.75rem;top:50%;transform:translateY(-50%);color:var(--textL);pointer-events:none">
                        <svg style="width:16px;height:16px" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </div>
                    <input
                        type="url"
                        id="github_link"
                        name="github_link"
                        value="{{ old('github_link', $project->github_link ?? '') }}"
                        placeholder="https://github.com/username/project"
                        class="a-input @error('github_link') !border-red-400 @enderror"
                        style="padding-left:2.375rem"
                    >
                </div>
                @error('github_link')
                    <div style="color:#ef4444;font-size:.75rem;margin-top:.3rem" role="alert">{{ $message }}</div>
                @enderror
            </div>

            {{-- Live Demo URL --}}
            <div style="margin-bottom:1.25rem">
                <label for="link" class="a-label">Live Demo URL</label>
                <div style="position:relative">
                    <div style="position:absolute;left:.75rem;top:50%;transform:translateY(-50%);color:var(--textL);pointer-events:none">
                        <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <input
                        type="url"
                        id="link"
                        name="link"
                        value="{{ old('link', $project->link ?? '') }}"
                        placeholder=""
                        class="a-input @error('link') !border-red-400 @enderror"
                        style="padding-left:2.375rem"
                    >
                </div>
                @error('link')
                    <div style="color:#ef4444;font-size:.75rem;margin-top:.3rem" role="alert">{{ $message }}</div>
                @enderror
                <div style="font-size:.75rem;color:var(--textM);margin-top:.35rem">
                    Paste your deployed project URL (InfinityFreeApp, Vercel, Render, etc.)
                </div>
            </div>

            {{-- Status --}}
            <div style="margin-bottom:1.25rem">
                <label for="status" class="a-label">
                    Project Status
                    <span style="color:#ef4444;margin-left:2px" aria-hidden="true">*</span>
                </label>
                <div style="position:relative">
                    <select
                        id="status"
                        name="status"
                        class="a-input @error('status') !border-red-400 @enderror"
                        style="appearance:none;padding-right:2.5rem"
                    >
                        @foreach(['completed' => 'Completed', 'ongoing' => 'Ongoing', 'planned' => 'Planned'] as $val => $label)
                            <option value="{{ $val }}" {{ old('status', $project->status ?? 'completed') === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <div style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);pointer-events:none;color:var(--textL)">
                        <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
                @error('status')
                    <div style="color:#ef4444;font-size:.75rem;margin-top:.3rem" role="alert">{{ $message }}</div>
                @enderror
            </div>

            {{-- Current & New Image --}}
            <div style="margin-bottom:1.75rem">
                <label class="a-label">Project Image</label>

                {{-- Current image preview --}}
                @if(!empty($project->image))
                    <div style="margin-bottom:1rem">
                        <div style="font-size:.75rem;color:var(--textM);margin-bottom:.5rem;font-weight:500;text-transform:uppercase;letter-spacing:.05em">Current Image</div>
                        <div class="img-preview-wrap" style="max-width:100%">
                            @if(Str::startsWith($project->image, ['http://', 'https://']))
                                <img src="{{ $project->image }}" alt="{{ $project->title }}">
                            @else
                                <img src="{{ asset('storage/'.$project->image) }}" alt="{{ $project->title }}">
                            @endif
                            <span class="img-overlay-badge">Current</span>
                        </div>
                    </div>
                @endif

                {{-- Upload new image --}}
                <div
                    x-data="editImageUpload()"
                    @dragover.prevent="dragging = true"
                    @dragleave.prevent="dragging = false"
                    @drop.prevent="handleDrop($event)"
                    :class="dragging ? 'border-[var(--p)] bg-[var(--p-50)]' : 'border-[var(--border)] hover:border-[var(--p)]'"
                    style="border:2px dashed var(--border);border-radius:var(--r);padding:1.5rem;text-align:center;cursor:pointer;transition:all var(--ease);background:var(--surface2)"
                    @click="$refs.imgInput.click()"
                    role="button"
                    tabindex="0"
                    @keydown.enter="$refs.imgInput.click()"
                    @keydown.space.prevent="$refs.imgInput.click()"
                    aria-label="Click to upload a new image"
                >
                    <template x-if="preview">
                        <div style="position:relative;display:inline-block;margin-bottom:.5rem">
                            <img :src="preview" alt="New image preview" style="max-height:160px;max-width:100%;border-radius:var(--r-sm);object-fit:cover;display:block;margin:0 auto">
                            <button
                                type="button"
                                @click.stop="clearImage()"
                                style="position:absolute;top:-8px;right:-8px;width:24px;height:24px;background:#ef4444;border-radius:50%;color:white;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center"
                                aria-label="Remove new image"
                            >
                                <svg style="width:12px;height:12px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </template>

                    <template x-if="!preview">
                        <div>
                            <div style="color:var(--p);margin-bottom:.5rem;display:flex;justify-content:center">
                                <svg style="width:28px;height:28px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <p style="font-size:.8125rem;font-weight:500;color:var(--text);margin-bottom:.2rem">
                                {{ !empty($project->image) ? 'Click to replace image' : 'Click to upload image' }}
                            </p>
                            <p style="font-size:.75rem;color:var(--textM)">PNG, JPG, WebP — max 5 MB</p>
                        </div>
                    </template>

                    <input
                        type="file"
                        name="image"
                        accept="image/*"
                        x-ref="imgInput"
                        @change="handleFile($event)"
                        style="display:none"
                        aria-hidden="true"
                    >
                </div>

                @error('image')
                    <div style="color:#ef4444;font-size:.75rem;margin-top:.3rem" role="alert">{{ $message }}</div>
                @enderror
            </div>

            {{-- Buttons --}}
            <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;padding-top:1.25rem;border-top:1px solid var(--border);flex-wrap:wrap">

                <div style="display:flex;gap:.625rem;align-items:center">
                    <a href="{{ route('admin.projects.index') }}" class="a-btn a-btn-ghost">
                        Cancel
                    </a>

                    {{-- Delete button (secondary, dangerous) --}}
                    <button
                        type="submit"
                        form="delete-project-{{ $project->id }}"
                        class="a-btn a-btn-danger"
                    >
                        <svg style="width:15px;height:15px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </div>

                <button
                    type="submit"
                    class="a-btn a-btn-primary"
                    :disabled="submitting"
                    :style="submitting ? 'opacity:.7;cursor:not-allowed' : ''"
                >
                    <svg x-show="!submitting" style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <svg x-show="submitting" style="width:16px;height:16px;animation:spin 1s linear infinite" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span x-text="submitting ? 'Updating...' : 'Update Project'"></span>
                </button>
            </div>

        </form>

        <form
            id="delete-project-{{ $project->id }}"
            action="{{ route('admin.projects.destroy', $project) }}"
            method="POST"
            onsubmit="return confirm('Permanently delete \'{{ addslashes($project->title) }}\'? This cannot be undone.')"
            style="display:none"
        >
            @csrf
            @method('DELETE')
        </form>
    </div>

    {{-- ---- Meta sidebar ---- --}}
    <div style="display:flex;flex-direction:column;gap:1rem">

        {{-- Project metadata --}}
        <div class="a-card" style="padding:1.25rem">
            <h3 style="font-size:.875rem;font-weight:600;color:var(--text);margin-bottom:.875rem">Project Info</h3>
            <div style="display:flex;flex-direction:column;gap:.625rem;font-size:.8125rem">
                <div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem">
                    <span style="color:var(--textM)">ID</span>
                    <span style="color:var(--text);font-weight:500;font-family:monospace;font-size:.8rem">#{{ $project->id }}</span>
                </div>
                <div style="height:1px;background:var(--border)"></div>
                <div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem">
                    <span style="color:var(--textM)">Slug</span>
                    <span style="color:var(--text);font-weight:500;font-size:.75rem;font-family:monospace">{{ $project->slug ?? '—' }}</span>
                </div>
                <div style="height:1px;background:var(--border)"></div>
                <div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem">
                    <span style="color:var(--textM)">Created</span>
                    <span style="color:var(--text);font-weight:500">{{ $project->created_at->format('M d, Y') }}</span>
                </div>
                <div style="height:1px;background:var(--border)"></div>
                <div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem">
                    <span style="color:var(--textM)">Updated</span>
                    <span style="color:var(--text);font-weight:500">{{ $project->updated_at->diffForHumans() }}</span>
                </div>
                <div style="height:1px;background:var(--border)"></div>
                <div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem">
                    <span style="color:var(--textM)">Status</span>
                    @php
                        $sm = ['completed'=>['Completed','#dcfce7','#15803d'],'ongoing'=>['Ongoing','#dbeafe','#1d4ed8'],'planned'=>['Planned','#fef9c3','#a16207']];
                        [$sl,$sb,$sc] = $sm[$project->status ?? 'completed'] ?? $sm['completed'];
                    @endphp
                    <span style="font-size:.6875rem;font-weight:600;padding:.2rem .55rem;border-radius:20px;background:{{ $sb }};color:{{ $sc }}">{{ $sl }}</span>
                </div>
                @if(!empty($project->image))
                <div style="height:1px;background:var(--border)"></div>
                <div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem">
                    <span style="color:var(--textM)">Image</span>
                    <span class="a-badge a-badge-success">Uploaded</span>
                </div>
                @endif
            </div>
        </div>

        {{-- View live link --}}
        @if(!empty($project->slug))
        <div class="a-card" style="padding:1.25rem;display:flex;flex-direction:column;gap:.625rem">
            <h3 style="font-size:.875rem;font-weight:600;color:var(--text);margin-bottom:.125rem">Quick Links</h3>
            <a href="{{ route('projects.show', $project->slug) }}"
               target="_blank"
               class="a-btn a-btn-ghost"
               style="width:100%;justify-content:center">
                <svg style="width:15px;height:15px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                View on Portfolio
            </a>
            @if(!empty($project->link))
            <a href="{{ $project->link }}"
               target="_blank"
               class="a-btn a-btn-primary"
               style="width:100%;justify-content:center">
                <svg style="width:15px;height:15px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                </svg>
                Open Live Demo →
            </a>
            @endif
        </div>
        @endif

        {{-- Danger zone --}}
        <div class="a-card" style="padding:1.25rem;border-color:#fecdd3" x-data="{open:false}">
            <button
                @click="open = !open"
                style="width:100%;display:flex;align-items:center;justify-content:space-between;background:none;border:none;cursor:pointer;font-size:.875rem;font-weight:600;color:#e11d48;font-family:inherit"
            >
                <span style="display:flex;align-items:center;gap:.5rem">
                    <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Danger Zone
                </span>
                <svg :style="open ? 'transform:rotate(180deg)' : ''" style="width:14px;height:14px;transition:transform .2s" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" x-transition style="display:none;margin-top:.875rem;padding-top:.875rem;border-top:1px solid #fecdd3">
                <p style="font-size:.8125rem;color:var(--textM);margin-bottom:.875rem">
                    Permanently delete this project. This action <strong>cannot be undone</strong>.
                </p>
                <form action="{{ route('admin.projects.destroy', $project) }}"
                      method="POST"
                      onsubmit="return confirm('Are you absolutely sure you want to delete \'{{ addslashes($project->title) }}\'?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="a-btn a-btn-danger" style="width:100%;justify-content:center">
                        <svg style="width:15px;height:15px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Project
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>

<style>
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
@media (max-width: 820px) {
    #edit-grid { grid-template-columns: 1fr !important; }
}
</style>

<script>
function editForm() {
    return {
        submitting: false,
    };
}

function editImageUpload() {
    return {
        preview: null,
        dragging: false,

        handleFile(event) {
            const file = event.target.files[0];
            if (file) this.setPreview(file);
        },

        handleDrop(event) {
            this.dragging = false;
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                this.$refs.imgInput.files = event.dataTransfer.files;
                this.setPreview(file);
            }
        },

        setPreview(file) {
            const reader = new FileReader();
            reader.onload = (e) => { this.preview = e.target.result; };
            reader.readAsDataURL(file);
        },

        clearImage() {
            this.preview = null;
            this.$refs.imgInput.value = '';
        },
    };
}
</script>

@endsection
