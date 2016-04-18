<?php

namespace App\Listeners;

use App\Events\CollectionViewed;
use Illuminate\Support\Facades\Auth;

class IncrementCollectionViews
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CollectionViewed $event
     * @return void
     */
    public function handle(CollectionViewed $event)
    {
        if (!Auth::check() || (Auth::check() && $event->collection->user->id != Auth::user()->id)) {
            $event->collection->increment('views');
        }
    }
}
