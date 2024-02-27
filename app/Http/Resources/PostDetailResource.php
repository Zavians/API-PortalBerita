<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
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
            'author'=> $this->author,
            'title'=> $this->title,
            'image'=> $this->image,
            'news_content' => $this->news_content,
            'created_at'=> date("Y/m/d H:i:s", strtotime($this->created_at)), 
            'writer' => $this->whenLoaded('writer'),
            'comments' => $this->whenLoaded('comments', function () {
                return collect($this->comments)->each(function ($comment){
                    $comment->comentator;
                    return $comment;
                });
            }),

            'comment_total'=> $this ->whenLoaded('comments', function (){
                return $this->comments->count();
            })
        ];
    }
}
