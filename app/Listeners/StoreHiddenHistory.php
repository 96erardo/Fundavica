<?php

namespace App\Listeners;

use Auth;
use Carbon\Carbon;
use App\Models\UserModPost;
use App\Events\HiddenPost;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreHiddenHistory
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
     * @param  HiddenPost  $event
     * @return void
     */
    public function handle(HiddenPost $event)
    {
        $user_mod_post = new UserModPost();
        $user_mod_post->created_at = Carbon::now();
        $user_mod_post->usuario_id = Auth::user()->id;
        $user_mod_post->publicacion_id = $event->post->id;
        $user_mod_post->operacion_id = 3;
        $user_mod_post->save();
    }
}
