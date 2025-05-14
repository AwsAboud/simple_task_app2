<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date?->toDateString(),
            'status' => $this->whenLoaded('status', fn() => $this->status->label),
            'priority' => $this->whenLoaded('priority', fn() => $this->priority->label),
            'assignees' => $this->whenLoaded('users', fn() => $this->users->pluck('name')),
            'comments' => $this->when(
                $request->routeIs('tasks.show'), 
                CommentResource::collection($this->whenLoaded('comments'))
            ),
        ];
    }
}
