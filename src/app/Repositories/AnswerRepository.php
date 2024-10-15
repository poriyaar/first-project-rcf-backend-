<?php

namespace App\Repositories;

use App\Models\Answer;
use App\Models\Thread;


class AnswerRepository
{

    public function getAllAnswers()
    {
        return Answer::query()->latest()->get();
    }

    public function store($request)
    {
        Thread::find($request->thread_id)->answers()->create([
            'content' => $request->input('content'),
            'user_id' => auth()->id()
        ]);
    }


    public function update($answer,$request)
    {
       $answer->update([
            'content' => $request->input('content'),
        ]);
    }

    public function destroy($answer)
    {
        $answer->delete();
    }
}
