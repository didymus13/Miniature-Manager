<?php

namespace App\Events;

use App\Collection;
use Illuminate\Queue\SerializesModels;

class CollectionViewed extends Event
{
    use SerializesModels;

    public $collection;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
