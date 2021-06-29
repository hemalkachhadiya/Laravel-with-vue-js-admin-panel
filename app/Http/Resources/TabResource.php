<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TabResource extends JsonResource
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
            'url' => $this->url,
            'icon' => $this->icon,
            'name' => $this->name,
            'status' => $this->status,
            'position' => $this->position,
            'type' => $this->type,
            'tab_id' => $this->tab_id
        ];
    }
}
