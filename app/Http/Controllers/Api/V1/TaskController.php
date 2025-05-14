<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;

class TaskController extends Controller
{
     public function __construct(private TaskService $taskService) {}
     
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         Gate::authorize('viewAny', Task::class);
         $tasks = $this->taskService->getAll();

        return $this->successResponse(TaskResource::collection($tasks));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        Gate::authorize('create', Task::class);
        $data = $request->validated();
        $data['created_by'] = auth()->id();
        $task = $this->taskService->create($data);

       return $this->successResponse(new TaskResource($task));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        Gate::authorize('view', $task);
        $task = $this->taskService->getOne($task);

       return $this->successResponse(new TaskResource($task));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);
        $this->taskService->update($task, $request->validated());

        return $this->successResponse(new TaskResource($task));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);
        $this->taskService->delete($task);

        return $this->successResponse(null);
    }
}
