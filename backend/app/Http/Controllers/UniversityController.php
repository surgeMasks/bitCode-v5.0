<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class UniversityController extends Controller
{
    public function index()
    {
       $university = University::all();
        return response()->json($university, 200);
    }
}
