<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'start_day' => 'required|date',
            'end_day' => 'required|date|after_or_equal:start_day',
            'project_id' => 'required|integer|exists:projects,id'
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'projects_id' => $request->project_id,
            'task_name' => $request->task_name,
            'start_day' => $request->start_day,
            'end_day' => $request->end_day,
            'fix' => false
        ]);

        return redirect()->back()->with('success', 'タスクが作成されました。');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'start_day' => 'required|date',
            'end_day' => 'required|date|after_or_equal:start_day',
        ]);

        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        
        $task->update([
            'start_day' => $request->start_day,
            'end_day' => $request->end_day,
            'fix' => $request->has('fix')
        ]);

        return redirect()->back()->with('success', 'タスクが更新されました。');
    }

    public function delete($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'タスクが削除されました。');
    }
}
