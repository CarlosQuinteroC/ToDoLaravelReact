<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display tasks for the authenticated user
        // Get the authenticated user
        $user = Auth::user();
        // If the user is not authenticated, redirect to the login page with an error message
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to view tasks.');
        }

        // This retrieves all tasks for the authenticated user that do not have a parent task
        // and includes their subtasks.
        $tasks = $user->tasks()->whereNull('parent_id')->with('subtasks')->get();


        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'user' => $user,
        ]);
    }
    public function create()
    {
        // Logic to show the form for creating a new task
        // This could return a view or an Inertia response with a form component
        return Inertia::render('Tasks/Create', [
            'user' => Auth::user(),
        ]);
    }
    public function store(Request $request)
    {
        // Logic to store a new task using the validated data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:New,Pending,In Progress,Completed',
            'due_date' => 'nullable|date',
            'parent_id' => 'nullable|exists:tasks,id',
        ]);
        // Inject the authenticated user ID (ignore any frontend value)
        $validatedData['user_id'] = auth()->id();

        $task = Task::create($validatedData);
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }
    public function show($id)
    {
        // Logic to display a specific task
        $user = Auth::user();
        // If the user is not authenticated, redirect to the login page with an error message
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to view tasks.');
        }
        // Ensure the task belongs to the authenticated user
        $task = Task::with('subtasks')->where('id', $id)->where('user_id', $user->id)->first();
        if (!$task) {
            return redirect()->route('tasks.index')->with('error', 'Task not found or you do not have permission to view it.');
        }

        return Inertia::render('Tasks/Show', [
            'task' => $task,
            'user' => $user,
        ]);
    }
    public function edit($id)
    {
        // Logic to show the form for editing a specific task
    }
    public function update(Request $request, $id)
    {
        // Logic to update a specific task
        $user = Auth::user();
        // If the user is not authenticated, redirect to the login page with an error message
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to update tasks.');
        }
        // Ensure the task belongs to the authenticated user
        $task = Task::where('id', $id)->where('user_id', $user->id)->first();
        if (!$task) {
            return redirect()->route('tasks.index')->with('error', 'Task not found or you do not have permission to update it.');
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:New,Pending,In Progress,Completed',
            'due_date' => 'nullable|date',
            'parent_id' => 'nullable|exists:tasks,id',
        ]);
        // Update the task with the validated data
        $task->update($validatedData);
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }
    public function destroy($id)
    {
        // Logic to delete a specific task
        $user = Auth::user();
        // If the user is not authenticated, redirect to the login page with an error message
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to delete tasks.');
        }
        // Ensure the task belongs to the authenticated user
        $task = Task::where('id', $id)->where('user_id', $user->id)->first();
        if (!$task) {
            return redirect()->route('tasks.index')->with('error', 'Task not found or you do not have permission to delete it.');
        }
        // Delete the task
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
    public function complete($id)
    {
        // Logic to mark a task as completed
    }
    public function subtasks($id)
    {
        // Logic to retrieve subtasks for a specific task
        $user = Auth::user();
        // If the user is not authenticated, redirect to the login page with an error message
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to view subtasks.');
        }
        // Ensure the task belongs to the authenticated user
        $task = Task::where('id', $id)->where('user_id', $user->id)->first();
        if (!$task) {
            return redirect()->route('tasks.index')->with('error', 'Task not found or you do not have permission to view subtasks.');
        }
        // Retrieve subtasks
        $subtasks = $task->subtasks;

        return Inertia::render('Tasks/Subtasks', [
            'task' => $task,
            'subtasks' => $subtasks,
            'user' => $user,
        ]);
    }
}
