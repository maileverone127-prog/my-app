@extends('layouts.admin')

@section('title', 'Add New Project')

@section('breadcrumb')
<nav class="breadcrumb" aria-label="Breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep" aria-hidden="true">/</span>
    <a href="{{ route('admin.projects.index') }}">Projects</a>
    <span class="breadcrumb-sep" aria-hidden="true">/</span>
    <span style="color:var(--text);font-weight:600">Add New</span>
</nav>
@endsection

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="page-header" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem">
    <div>
        <h1 class="page-title">Add New Project</h1>
        <p class="page-subtitle">Create a new portfolio project with image and details.</p>
    </div>
    <a href="{{ route('admin.projects.index') }}"
       class="a-btn a-btn-ghost">
        <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Projects
    </a>
</div>

{{-- ===== FORM GRID ===== --}}
<div class="grid animate-fade-in-up" style="grid-template-columns:1fr minmax(0,340px);gap:1.5rem;align-items:start" id="create-grid">

    {{-- ---- Main Form ---- --}}
    <div class="a-card" style="padding:1.75rem">

        {{-- Error messages --}}
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

        <form action="{{ route('admin.projects.store') }}"
              method="POST"
              enctype="multipart/form-data"
              x-data="createForm()"
              @submit="submitting = true"
              novalidate>
            @csrf

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
                    value="{{ old('title') }}"
                    required
                    autocomplete="off"
                    placeholder="e.g. Laravel E-Commerce Platform"
                    class="a-input @error('title') border-red-400 @enderror"
                    aria-describedby="title-hint"
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
                    placeholder="Describe what the project does, technologies used, key features..."
                    class="a-input a-textarea @error('description') border-red-400 @enderror"
                >{{ old('description') }}</textarea>
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
                        value="{{ old('github_link') }}"
                        placeholder="https://github.com/username/project"
                        class="a-input @error('github_link') border-red-400 @enderror"
                        style="padding-left:2.375rem"
                    >
                </div>
                @error('github_link')
                    <div style="color:#ef4444;font-size:.75rem;margin-top:.3rem" role="alert">{{ $message }}</div>
                @enderror
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
                        class="a-input @error('status') border-red-400 @enderror"
                        style="appearance:none;padding-right:2.5rem"
                    >
                        @foreach(['completed' => 'Completed', 'ongoing' => 'Ongoing', 'planned' => 'Planned'] as $val => $label)
                            <option value="{{ $val }}" {{ old('status', 'completed') === $val ? 'selected' : '' }}>
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

            {{-- Image Upload --}}
            <div style="margin-bottom:1.75rem">
                <label for="image" class="a-label">
                    Project Image
                    <span style="color:#ef4444;margin-left:2px" aria-hidden="true">*</span>
                </label>

                {{-- Drop zone --}}
                <div
                    @dragover.prevent="dragging = true"
                    @dragleave.prevent="dragging = false"
                    @drop.prevent="handleDrop($event)"
                    :class="dragging ? 'border-[var(--p)] bg-[var(--p-50)]' : 'border-[var(--border)] hover:border-[var(--p)]'"
                    style="border:2px dashed var(--border);border-radius:var(--r);padding:2rem;text-align:center;cursor:pointer;transition:all var(--ease);background:var(--surface2)"
                    @click="$refs.fileInput.click()"
                    role="button"
                    tabindex="0"
                    @keydown.enter="$refs.fileInput.click()"
                    @keydown.space.prevent="$refs.fileInput.click()"
                    aria-label="Click or drag to upload image"
                >
                    {{-- Preview --}}
                    <template x-if="preview">
                        <div style="position:relative;display:inline-block;margin-bottom:.75rem">
                            <img :src="preview" alt="Preview" style="max-height:180px;max-width:100%;border-radius:var(--r-sm);object-fit:cover;display:block;margin:0 auto">
                            <button
                                type="button"
                                @click.stop="clearImage()"
                                style="position:absolute;top:-8px;right:-8px;width:24px;height:24px;background:#ef4444;border-radius:50%;color:white;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center"
                                aria-label="Remove image"
                            >
                                <svg style="width:12px;height:12px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </template>

                    <template x-if="!preview">
                        <div>
                            <div style="width:52px;height:52px;border-radius:50%;background:var(--p-50);display:flex;align-items:center;justify-content:center;margin:0 auto .875rem;color:var(--p)">
                                <svg style="width:24px;height:24px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <p style="font-size:.875rem;font-weight:500;color:var(--text);margin-bottom:.25rem">
                                Click to upload or drag & drop
                            </p>
                            <p style="font-size:.75rem;color:var(--textM)">PNG, JPG, GIF, WebP — max 5 MB</p>
                        </div>
                    </template>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        required
                        accept="image/*"
                        x-ref="fileInput"
                        @change="handleFile($event)"
                        style="display:none"
                        aria-hidden="true"
                    >
                </div>

                <p class="a-input-hint" x-show="preview" x-text="fileName"></p>

                @error('image')
                    <div style="color:#ef4444;font-size:.75rem;margin-top:.3rem" role="alert">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit --}}
            <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;padding-top:1.25rem;border-top:1px solid var(--border);flex-wrap:wrap">
                <a href="{{ route('admin.projects.index') }}"
                   class="a-btn a-btn-ghost">
                    Cancel
                </a>
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
                    <span x-text="submitting ? 'Saving...' : 'Save Project'"></span>
                </button>
            </div>

        </form>
    </div>

    {{-- ---- Tips Sidebar ---- --}}
    <div style="display:flex;flex-direction:column;gap:1rem">

        {{-- Upload tips --}}
        <div class="a-card" style="padding:1.25rem">
            <h3 style="font-size:.875rem;font-weight:600;color:var(--text);margin-bottom:.875rem;display:flex;align-items:center;gap:.5rem">
                <svg style="width:16px;height:16px;color:var(--p)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Image Guidelines
            </h3>
            <ul style="font-size:.8125rem;color:var(--textM);line-height:1.8;list-style:none;padding:0;margin:0">
                <li style="display:flex;align-items:flex-start;gap:.5rem">
                    <span style="color:var(--p);margin-top:.125rem;flex-shrink:0">✓</span>
                    Use 16:9 or 4:3 aspect ratio for best display
                </li>
                <li style="display:flex;align-items:flex-start;gap:.5rem">
                    <span style="color:var(--p);margin-top:.125rem;flex-shrink:0">✓</span>
                    Minimum 800×500 px recommended
                </li>
                <li style="display:flex;align-items:flex-start;gap:.5rem">
                    <span style="color:var(--p);margin-top:.125rem;flex-shrink:0">✓</span>
                    PNG, JPG, GIF, or WebP accepted
                </li>
                <li style="display:flex;align-items:flex-start;gap:.5rem">
                    <span style="color:var(--p);margin-top:.125rem;flex-shrink:0">✓</span>
                    Max file size: 5 MB
                </li>
                <li style="display:flex;align-items:flex-start;gap:.5rem">
                    <span style="color:var(--p);margin-top:.125rem;flex-shrink:0">✓</span>
                    Image is stored on Cloudinary CDN
                </li>
            </ul>
        </div>

        {{-- Description tips --}}
        <div class="a-card" style="padding:1.25rem">
            <h3 style="font-size:.875rem;font-weight:600;color:var(--text);margin-bottom:.875rem;display:flex;align-items:center;gap:.5rem">
                <svg style="width:16px;height:16px;color:#f59e0b" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m1.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                Writing Tips
            </h3>
            <ul style="font-size:.8125rem;color:var(--textM);line-height:1.8;list-style:none;padding:0;margin:0">
                <li style="display:flex;align-items:flex-start;gap:.5rem">
                    <span style="color:#f59e0b;margin-top:.125rem;flex-shrink:0">→</span>
                    Mention the tech stack used
                </li>
                <li style="display:flex;align-items:flex-start;gap:.5rem">
                    <span style="color:#f59e0b;margin-top:.125rem;flex-shrink:0">→</span>
                    Highlight key features
                </li>
                <li style="display:flex;align-items:flex-start;gap:.5rem">
                    <span style="color:#f59e0b;margin-top:.125rem;flex-shrink:0">→</span>
                    Add your GitHub link if open-source
                </li>
                <li style="display:flex;align-items:flex-start;gap:.5rem">
                    <span style="color:#f59e0b;margin-top:.125rem;flex-shrink:0">→</span>
                    Keep it concise but descriptive
                </li>
            </ul>
        </div>

    </div>

</div>

<style>
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
@media (max-width: 820px) {
    #create-grid { grid-template-columns: 1fr !important; }
}
</style>

<script>
function createForm() {
    return {
        preview: null,
        fileName: '',
        dragging: false,
        submitting: false,

        handleFile(event) {
            const file = event.target.files[0];
            if (file) this.setPreview(file);
        },

        handleDrop(event) {
            this.dragging = false;
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                this.$refs.fileInput.files = event.dataTransfer.files;
                this.setPreview(file);
            }
        },

        setPreview(file) {
            this.fileName = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
            const reader = new FileReader();
            reader.onload = (e) => { this.preview = e.target.result; };
            reader.readAsDataURL(file);
        },

        clearImage() {
            this.preview = null;
            this.fileName = '';
            this.$refs.fileInput.value = '';
        },
    };
}
</script>

@endsection
