<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'message' => $this->message,
            'user_id'=> $this->user_id,
            'update_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'show_on' => $this->show_on,
            'topic_id' => $this->topic_id,
            'user_name' => $this->user->name,
        ];
    }
}
