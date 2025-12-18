<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->isFinished) {
            return [
                'id' => $this->id,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'finished_at' => $this->finished_at,
                'votes' => VoteResource::collection($this->votes),
                'votes_average' => $this->votes_average,
                'votes_count' => $this->votes_count
            ];
        }

        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'finished_at' => null,
            'votes_count' => $this->votes_count,
            'votes_average' => null,
            'votes' => VoteResource::collection($this->votes),
        ];
    }
}
