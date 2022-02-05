<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
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
            'udid' => $this->udid,
            'user_id' => $this->user_id,
            'token' => $this->token,
            'date_test' => $this->date_test,
            'covid' => $this->covid,
            'risk' => $this->risk,
        ];
    }
}
