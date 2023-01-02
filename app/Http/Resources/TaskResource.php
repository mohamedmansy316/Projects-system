<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->name,
            'description' => $this->description,
            'project_id' => $this->project_id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'user_description' => $this->user_description,
            'created_at' => $this->created_at->format('d/m/Y'),
        ];
    }
}
