<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projectId = $request->input('project_id');
        $userId = $request->input('user_id');
        $userName = Auth::user()->name;
        
        return view('project.index', compact('projectId', 'userId', 'userName'));
    }
}
