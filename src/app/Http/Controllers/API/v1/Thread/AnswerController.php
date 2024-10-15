<?php

namespace App\Http\Controllers\API\v1\Thread;

use App\Models\User;
use App\Models\Answer;
use App\Models\Thread;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Repositories\AnswerRepository;
use App\Notifications\NewReplaySubmitted;
use App\Repositories\SubscribeRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Notification;

class AnswerController extends Controller
{

    public function index()
    {
        $answers = resolve(AnswerRepository::class)->getAllAnswers();

        return response()->json([
            $answers
        ], Response::HTTP_OK);
    }


    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'thread_id' => 'required',
        ]);

        resolve(AnswerRepository::class)->store($request);

        // Get list of user id which subscribed To A thread id
        $notifiable_user_id = resolve(SubscribeRepository::class)->getNotifiableUser($request->thread_id);
        // Get User instance from id
        $notifiable_users = resolve(UserRepository::class)->find($notifiable_user_id);
        // send NewReplaySubmitted notification to subscribe users
        Notification::send($notifiable_users, new NewReplaySubmitted(Thread::find($request->thread_id)));

        return response()->json([
            'message' => 'answer submitted successfully'
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, Answer $answer)
    {
        $request->validate([
            'content' => 'required',
        ]);

        if (Gate::forUser(auth()->user())->allows('user-answer', $answer)) {
            resolve(AnswerRepository::class)->update($answer, $request);


            return response()->json([
                'message' => 'answer updated successfully'
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'access denied'
        ], Response::HTTP_FORBIDDEN);
    }


    public function destroy(Answer $answer)
    {

        if (Gate::forUser(auth()->user())->allows('user-answer', $answer)) {

            resolve(AnswerRepository::class)->destroy($answer);

            return response()->json([
                'message' => 'answer deleted successfully'
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'access denied'
        ], Response::HTTP_FORBIDDEN);
    }
}
