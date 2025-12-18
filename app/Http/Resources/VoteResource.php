<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $vote = null;

        if ($this->round->isFinished) {
            $vote = $this->vote;
        }

        return [
            'id' => $this->when($this->id, $this->id),
            'name' => $this->name,
            'vote' => $vote,
        ];
    }
}
