<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchProfileResource extends JsonResource
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
            "searchProfileId" => $this->id,
            "matchesCount" => $this->matchesCount,
            "strictMatchesCount" => $this->strictMatchesCount,
            "looseMatchesCount" => $this->looseMatchesCount,
            "score" => $this->score,

        ];
    }
}
