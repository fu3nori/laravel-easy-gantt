<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index($id)
    {
        $projectId = $id;
        $userId = Auth::id();
        $userName = Auth::user()->name;
        
        // プロジェクト名を取得
        $project = Project::where('id', $projectId)
                         ->where('user_id', $userId)
                         ->first();
        
        if (!$project) {
            return redirect()->route('dashboard.index')->with('error', 'プロジェクトが見つかりません。');
        }
        
        $projectName = $project->project_name;
        
        // タスク一覧を取得
        $tasks = Task::where('user_id', $userId)
                    ->where('projects_id', $projectId)
                    ->orderBy('id')
                    ->get();
        
        return view('project.index', compact('projectId', 'userId', 'userName', 'projectName', 'tasks'));
    }
}
