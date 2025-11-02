<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        return response()->json($request->user()->tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean'
        ]);

        $task = $request->user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->completed ?? false,
        ]);

        return response()->json($task, 201);
    }

    public function show(Request $request, Task $task)
    {
        //
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Acesso negado'], 403);
        }

        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Acesso negado'], 403);
        }

        $request->validate([
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean'
        ]);

        $task->update($request->only(['title', 'description', 'completed']));

        return response()->json($task);
    }

    public function destroy(Request $request, Task $task)
    {
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Acesso negado'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Task deletada com sucesso']);
    }
}
