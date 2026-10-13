<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * GET /api/tasks?project_id=&status=&per_page=
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->validate([
            'project_id' => ['sometimes', 'integer'],
            'status' => ['sometimes', 'integer', 'between:0,6'],
            'per_page' => ['sometimes', 'integer', 'between:1,100'],
        ]);

        $tasks = Task::query()
            ->when(isset($filters['project_id']), fn ($query) => $query->where('project_id', $filters['project_id']))
            ->when(isset($filters['status']), fn ($query) => $query->where('status', $filters['status']))
            ->latest()
            ->latest('id')
            ->paginate($filters['per_page'] ?? 25)
            ->withQueryString();

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): TaskResource
    {
        $task = new Task($request->validated());
        $task->author_id = 1; // TODO: auth()->id() после Sanctum
        $task->save();

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): TaskResource
    {
        $task->load('project');

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        // TODO: completed_at при смене статуса (Observer)
        $task->update($request->validated());

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): Response
    {
        $task->delete();

        return response()->noContent();
    }
}
