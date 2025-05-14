<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use Dom\Comment;

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
        $comment = $this->commentService->create($data);
       
        return $this->successResponse(new CommentResource($comment));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest  $request, int $id): JsonResponse
    {
        $comment = $this->commentService->update($id, $request->validated());
        
        return $this->successResponse(new CommentResource($comment));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse 
    {
        $this->commentService->delete($id);
       
        return $this->successResponse(null);
    }
}
