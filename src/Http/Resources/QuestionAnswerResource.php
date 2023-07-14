<?php

namespace Wepa\Faq\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionAnswerResource extends JsonResource
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
            'category_id' => $this->category_id,
            'category_name' => $this->when(! $request->routeIs('*admin*.edit'), function () {
                return $this->category->name;
            }),
            'question' => $this->when(! $request->routeIs('*admin*.edit'), function () {
                return $this->question;
            }),
            'answer' => $this->when(! $request->routeIs('*admin*.edit'), function () {
                return $this->answer;
            }),
            'position' => $this->position,
            'draft' => $this->when($request->routeIs('*admin*.edit'), function () {
                return $this->draft;
            }),
            'translations' => $this->when($request->routeIs('*admin*.edit'), function () {
                return $this->getTranslationsArray();
            }),
        ];
    }
}
