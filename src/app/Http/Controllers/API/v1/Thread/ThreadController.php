<?php

namespace App\Http\Controllers\API\v1\Thread;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Repositories\ThreadRepository;
use Illuminate\Http\Response;

class ThreadController extends Controller
{

    public function index()
    {
        $threads = resolve(ThreadRepository::class)->getAllAvailableThreads();


        return response()->json($threads . Response::HTTP_OK);
    }

    public function show($slug)
    {
        $thread = resolve(ThreadRepository::class)->getThreadBySlug($slug);

        return response()->json($thread, Response::HTTP_OK);
    }
}
