<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    use FileTrait;

    public function index()
    {
        $projects = Project::all();
        return response()->json($projects, 200);
    }

    public function myIndex()
    {
        $projects = Project::where('user_id', Auth::user()->id);
        return response()->json($projects, 200);
    }

    public function store(Request $request)
    {
        $validatedRequest = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file' => 'required|file|mimes:rar|max:10240',
        ]);

       if ($request->hasFile('file')) {
            $file = $validatedRequest['file'];
            $file_path = $this->saveFile('files', $file, Auth::user()->id);
            $url = Storage::disk('files')->url($file_path);
            $validatedRequest['file_path'] = $url;
    }
    if ($request->hasFile('image')) {
        $file = $validatedRequest['image'];
        $file_path = $this->saveFile('images', $file, Auth::user()->id);
        $url = Storage::disk('images')->url($file_path);
        $validatedRequest['image_path'] = $url;
    }
        unset($validatedRequest['image']);
        unset($validatedRequest['file']);
        $validatedRequest['user_id'] = Auth::user()->id;
        $project = Project::create($validatedRequest);

        return response()->json([
            'message' => 'Project created successfully',
            'project' => $project
        ], 201);
    }

    public function show(Project $project)
    {
        return response()->json($project, 200);
    }

}

