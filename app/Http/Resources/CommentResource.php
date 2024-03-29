<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'id'=> $this->id,
            'post_id'=> $this->post_id,
            'user_id'=> $this->user_id,
            'comment_content'=> $this->comment_content,
            'created_at'=> date("Y-m-d H:i:s", strtotime($this->created_at)), 
            'comentator' => $this->whenLoaded('comentator'),
            'judulArtikel' => $this->whenLoaded('judulArtikel'),
        ];
    }
}
