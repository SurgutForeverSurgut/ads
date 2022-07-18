<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(!$this->resource){
            return;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->when($request->fields,$this->description),
            'images' => $request->fields ? $this->images : [$this->images->first()],
            'price' => $this->price,
        ];
    }
}
