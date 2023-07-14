<?php

namespace Wepa\Faq\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id' => $this->when($this->id, function () {
                return $this->id;
            }),
            'name' => $this->name,
            'position' => $this->position,
            'translations' => $this->when($request->routeIs('*admin*.edit'), function () {
                return $this->getTranslationsArray();
            }),
        ];
    }
}
