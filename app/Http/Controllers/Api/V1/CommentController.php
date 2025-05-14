<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\CommentResource;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;


class CommentController extends Controller
{

    public function __construct(private CommentService $commentService) {}
    

    // public function indexByTask(int $taskId): JsonResponse
    // {
    //      $comments = $this->commentService->getCommentsForTask($taskId);

    //     return $this->successResponse($comments);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest  $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $comment = $this->commentService->create($data);
       
        return $this->successResponse(new CommentResource($comment));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest  $request, Comment $comment): JsonResponse
    {
          Gate::authorize('update', $comment);
        $comment = $this->commentService->update($comment, $request->validated());
        
        return $this->successResponse(new CommentResource($comment));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): JsonResponse 
    {
        Gate::authorize('delete', $comment);
        $this->commentService->delete($comment);
       
        return $this->successResponse(null);
    }
}
