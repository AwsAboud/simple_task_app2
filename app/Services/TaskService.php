<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskService
{
     // Create Task
    public function create(array $data)
    {
        // pass 'created_by' => Auth::id(), from controller
        return DB::transaction(function () use ($data) {
            $task = Task::create($data);

            // If there are assigned users, assign them to the task
            if (isset($data['assigned_users'])) {
                
                    $this->syncUsersToTask($task, $data['assigned_users']);
            }

            return $task;
        });
    }

    // Get All Tasks
    public function getAll()
    {
        return Task::with('status', 'priority', 'users')->get();
    }

    // Ger a Task by ID
    public function getOne(Task $task)
    {
        return $task->load(['status', 'priority', 'users', 'comments']);
    }

    // Update Task
    public function update(Task $task, array $data)
    {
        return DB::transaction(function () use ($task, $data) {
            $task->update($data);

            // Update the assignment if necessary
            if (isset($data['assigned_users'])) {
                // Assign new users
                $this->syncUsersToTask($task, $data['assigned_users'], 'assignee');
            }

            return $task; 
        });
    }

    // Delete Task
    public function delete(Task $task)
    {
        $task->delete();
    }

    // Sync users with additional pivot data (role and assigned_at)
    public function syncUsersToTask(Task $task, array $assigned_users)
    {
       
        $syncData = [];

        foreach ($assigned_users as $user) {
            $syncData[$user['id']] = [
                'role' => $user['role'],
                'assigned_at' => now(),
            ];
        }

        $task->users()->sync($syncData);
    }


}
