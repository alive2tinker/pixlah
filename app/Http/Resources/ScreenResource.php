<?php

namespace App\Http\Resources;

use App\Models\Order;
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
        $orders = Order::where([
            ['screen_id', $this->id],
            ['status', '!=', 'served']
        ])->take(8)->get();
        return [
            'id' => $this->id,
            'attachments' => AttachmentResource::collection($this->attachments),
            'presentationMode' => $this->presentation_mode,
            'hasMessageBar' => $this->has_message_bar,
            'messages' => MessageResource::collection($this->messages),
            'orders' => OrderResource::collection($orders),
            'color1' => $this->color_1,
            'color2' => $this->color_2,
            'color3' => $this->color_3
        ];
    }
}
