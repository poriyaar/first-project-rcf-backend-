<?php

namespace App\Http\Controllers\API\v1\Channel;

use App\Models\Channel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ChannelRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ChannelController extends Controller
{
    public function getAllChannelsList()
    {
        $all_channel = resolve(ChannelRepository::class)->all();
        return response()->json( $all_channel , Response::HTTP_OK);
    }


    /**
     * Create New Channel
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createNewChannel(Request $request)
    {
        $request->validate([
            'name' => ['required']
        ]);

        // Insert Channel to database
        resolve(ChannelRepository::class)->create($request->name);

        return response()->json([
            'message' => 'channel created successfully'
        ] ,Response::HTTP_CREATED);
    }

    /**
     * Update Channel
     *
     * @param Request $request
     * @return JsonResource
     */
    public function updateChannel(Request $request)
    {
        $request->validate([
            'name' => ['required']
        ]);

        // Update Channel to database
        resolve(ChannelRepository::class)->update($request);

        return response()->json([
            'message' => 'channel edited successfully'
        ] , Response::HTTP_OK);
    }


    /**
     * Delete Channel(s)
     *
     * @param Request $request
     * @return JsonResource
     */
    public function deleteChannel(Request $request)
    {
        $request->validate([
            'id' => ['required']
        ]);

        resolve(ChannelRepository::class)->delete($request->id);

        return response()->json([
            'message' => 'channel deleted successfully'
        ] , Response::HTTP_OK);
    }
}
