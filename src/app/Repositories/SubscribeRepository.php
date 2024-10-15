<?php
namespace App\Repositories;

use App\Models\Subscribe;


class SubscribeRepository
{

    public function getNotifiableUser( $thread_id)
    {
        return Subscribe::query()->where('thread_id' , $thread_id)->pluck('user_id')->all();
    }

}









