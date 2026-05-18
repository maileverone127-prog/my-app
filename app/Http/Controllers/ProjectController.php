<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProjectController extends Controller
{
    /* ================= FRONTEND ================= */

    public function index()
    {
        $projects = Project::latest()->paginate(9);

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $relatedProjects = Project::where('id', '!=', $project->id)
            ->latest()
            ->take(3)
            ->get();

        return view('projects.show', compact('project', 'relatedProjects'));
    }

    /* ================= ADMIN ================= */

    public function adminIndex()
    {
        $projects = Project::latest()->paginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    /* ================= STORE PROJECT ================= */

    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'title'       => 'required|string|max:255|unique:projects,title',
            'description' => 'required|string',
            'image'       => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'github_link' => 'nullable|url|max:500',
        ]);

        // Generate slug
        $slug = Str::slug($validated['title']);

        if (Project::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        $validated['slug'] = $slug;

        // Upload image safely
        if ($request->hasFile('image')) {

            try {

                $result = Cloudinary::uploadApi()->upload(
                    $request->file('image')->getRealPath(),
                    ['folder' => 'projects']
                );

                $validated['image'] = $result['secure_url'];

            } catch (\Exception $e) {

                Log::error('Cloudinary upload failed (store): ' . $e->getMessage());

                return redirect()
                    ->route('admin.projects.create')
                    ->withInput()
                    ->withErrors([
                        'image' => 'Cloudinary upload failed: ' . $e->getMessage()
                    ]);
            }
        }

        // Save project
        Project::create($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project created successfully!');
    }

    /* ================= EDIT ================= */

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /* ================= UPDATE ================= */

    public function update(Request $request, Project $project)
    {
        // Validation
        $validated = $request->validate([
            'title'       => 'required|string|max:255|unique:projects,title,' . $project->id,
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'github_link' => 'nullable|url|max:500',
        ]);

        // Update slug if title changed
        if ($project->title !== $validated['title']) {

            $slug = Str::slug($validated['title']);

            if (
                Project::where('slug', $slug)
                    ->where('id', '!=', $project->id)
                    ->exists()
            ) {
                $slug .= '-' . time();
            }

            $validated['slug'] = $slug;
        }

        // Update image
        if ($request->hasFile('image')) {

            try {

                $result = Cloudinary::uploadApi()->upload(
                    $request->file('image')->getRealPath(),
                    ['folder' => 'projects']
                );

                $validated['image'] = $result['secure_url'];

            } catch (\Exception $e) {

                Log::error('Cloudinary upload failed (update): ' . $e->getMessage());

                return redirect()
                    ->route('admin.projects.edit', $project)
                    ->withInput()
                    ->withErrors([
                        'image' => 'Cloudinary upload failed: ' . $e->getMessage()
                    ]);
            }
        }

        // Update project
        $project->update($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project updated successfully!');
    }

    /* ================= DELETE ================= */

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project deleted successfully!');
    }
}