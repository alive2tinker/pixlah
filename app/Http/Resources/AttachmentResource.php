<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
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
            'link' => $this->link,
            'type' => $this->type,
            'duration' => $this->duration,
            'text' => $this->quote_text,
            'smLink' => $this->sm_link,
            'tweetInfo' => $this->tweet_info
        ];
    }
}
