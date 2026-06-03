<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BackupController extends Controller
{
    /* ================= INDEX ================= */

    public function index()
    {
        $projects = Project::latest()->get();
        return view('admin.backup.index', compact('projects'));
    }

    /* ================= EXPORT ALL ================= */

    public function exportAll()
    {
        $projects = Project::all()->map(fn ($p) => $this->projectToArray($p));

        $json = json_encode([
            'version'    => '1.0',
            'exported_at' => now()->toISOString(),
            'count'      => $projects->count(),
            'projects'   => $projects,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $filename = 'projects-backup-all-' . now()->format('Y-m-d_H-i-s') . '.json';

        return Response::make($json, 200, [
            'Content-Type'        => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /* ================= EXPORT SINGLE ================= */

    public function exportSingle(Project $project)
    {
        $json = json_encode([
            'version'    => '1.0',
            'exported_at' => now()->toISOString(),
            'count'      => 1,
            'projects'   => [$this->projectToArray($project)],
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $filename = 'project-' . $project->slug . '-' . now()->format('Y-m-d_H-i-s') . '.json';

        return Response::make($json, 200, [
            'Content-Type'        => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /* ================= IMPORT ================= */

    public function import(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:json|max:5120',
        ]);

        $contents = file_get_contents($request->file('backup_file')->getRealPath());
        $data     = json_decode($contents, true);

        if (json_last_error() !== JSON_ERROR_NONE || empty($data['projects'])) {
            return back()->withErrors(['backup_file' => 'Invalid backup file format.']);
        }

        $imported = 0;
        $skipped  = 0;
        $errors   = [];

        foreach ($data['projects'] as $item) {
            $validator = Validator::make($item, [
                'title'       => 'required|string|max:255',
                'description' => 'required|string',
                'status'      => 'required|in:completed,ongoing,planned',
            ]);

            if ($validator->fails()) {
                $errors[] = 'Skipped "' . ($item['title'] ?? 'unknown') . '": ' . implode(', ', $validator->errors()->all());
                $skipped++;
                continue;
            }

            if (Project::where('title', $item['title'])->exists()) {
                $skipped++;
                $errors[] = 'Skipped "' . $item['title'] . '": already exists.';
                continue;
            }

            $slug = Str::slug($item['title']);
            if (Project::where('slug', $slug)->exists()) {
                $slug .= '-' . time();
            }

            Project::create([
                'title'       => $item['title'],
                'description' => $item['description'],
                'image'       => $item['image'] ?? null,
                'link'        => $item['link'] ?? null,
                'github_link' => $item['github_link'] ?? null,
                'status'      => $item['status'],
                'slug'        => $slug,
            ]);

            $imported++;
        }

        $message = "Import complete: {$imported} imported, {$skipped} skipped.";

        return back()
            ->with('success', $message)
            ->with('import_errors', $errors);
    }

    /* ================= HELPER ================= */

    private function projectToArray(Project $project): array
    {
        return [
            'title'       => $project->title,
            'description' => $project->description,
            'image'       => $project->image,
            'link'        => $project->link,
            'github_link' => $project->github_link,
            'status'      => $project->status,
            'slug'        => $project->slug,
            'created_at'  => $project->created_at?->toISOString(),
        ];
    }
}
