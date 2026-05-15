<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResources extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {

        $lang = app()->getLocale();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image
        ];
    }

}
