<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PostResource;

class TopicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'show_on' => $this->show_on,
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'user_id' => $this->user_id,
            'board_id' => $this->board_id,
            'user_name' => $this->user->name,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'last_post' => [$this->post->last()]
        ];
    }
}
