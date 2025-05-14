<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentService
{
    
    // Get comments for a specific task
    public function getCommentsForTask(int $taskId, int $perPage = 10): LengthAwarePaginator
    {
        return Comment::where('task_id', $taskId)
                     ->with('user')
                     ->latest()
                     ->paginate($perPage);
    }

    // Create a new comment
    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    // Update an existing comment
    public function update(int $id, array $data): Comment
    {
        // TODO make sure that only user who create the comment can update it 
        $comment = Comment::findOrFail($id);

        // Only update the body
        $comment->update([
            'body' => $data['body']
        ]);

        return $comment;
    }

    //  Delete a comment

    public function delete(int $id): bool
    {
        // TODO make sure that only user who create the comment can delete it 
        
        $comment = Comment::findOrFail($id);

        return $comment->delete();
    }
}
