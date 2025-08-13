<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())->get();
        return view('dashboard.index', compact('projects'));
    }

    public function create_project(Request $request)
    {
        $request->validate([
            'project_name' => 'required|string|max:255'
        ]);

        Project::create([
            'user_id' => Auth::id(),
            'project_name' => $request->project_name
        ]);

        return redirect()->back()->with('success', 'プロジェクトが作成されました。');
    }

    public function delete_project($id)
    {
        $project = Project::where('user_id', Auth::id())->findOrFail($id);
        $project->delete();

        return redirect()->back()->with('success', 'プロジェクトが削除されました。');
    }
}
