<?php

namespace App\Events;

use App\Http\Resources\RoundResource;
use App\Models\Round;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoundVoteUpdated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public RoundResource $round;

    /**
     * Create a new event instance.
     */
    public function __construct(Round $round)
    {
        $round
            ->votes
            ->each
            ->makeHidden('id');

        $this->round = new RoundResource($round);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('rooms.' . $this->round->room->slug),
        ];
    }
}
