<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();
        $settings = Setting::instance();
        return view('home', compact('projects', 'settings'));
    }
}
