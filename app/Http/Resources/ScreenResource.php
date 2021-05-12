<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScreenResource extends JsonResource
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
            'attachments' => AttachmentResource::collection($this->attachments),
            'presentationMode' => $this->presentation_mode,
            'hasMessageBar' => $this->has_message_bar,
            'messages' => MessageResource::collection($this->messages)
        ];
    }
}
