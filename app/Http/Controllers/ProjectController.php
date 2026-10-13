<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * GET /api/projects?status=&per_page=
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->validate([
            'status' => ['sometimes', 'integer', 'between:0,6'],
            'per_page' => ['sometimes', 'integer', 'between:1,100'],
        ]);

        $projects = Project::query()
            ->when(isset($filters['status']), fn ($query) => $query->where('status', $filters['status']))
            ->latest()
            ->latest('id')
            ->paginate($filters['per_page'] ?? 25)
            ->withQueryString();

        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request): ProjectResource
    {
        $project = new Project($request->validated());
        $project->author_id = 1; // TODO: auth()->id() после Sanctum
        $project->save();

        return new ProjectResource($project);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project): ProjectResource
    {
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project): ProjectResource
    {
        // TODO: completed_at при смене статуса (Observer)
        $project->update($request->validated());

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): Response
    {
        // TODO: soft delete задач проекта (Observer)
        $project->delete();

        return response()->noContent();
    }
}
