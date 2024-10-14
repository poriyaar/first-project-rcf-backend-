<?php

namespace App\Repositories;

use App\Models\Thread;

class ThreadRepository
{

    /**
     * @method getAllAvailableThreads()
     *
     * @return Thread
     */
    public function getAllAvailableThreads()
    {
        return Thread::whereFlag(1)->latest()->get();
    }


    public function getThreadBySlug($slug)
    {
        return Thread::whereSlug($slug)->whereFlag(1)->first();
    }
}
