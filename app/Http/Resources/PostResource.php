<?php

namespace App\Http\Resources;

use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title'=> $this->title,
            'news_content' => $this->news_content,
            'created_at'=> date("Y/m/d H:i:s", strtotime($this->created_at)),
        ];
    }
}
