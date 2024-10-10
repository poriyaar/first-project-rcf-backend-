<?php
namespace App\Repositories;

use App\Models\Channel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ChannelRepository
{

    /**
     * All Channel list
     */
    public function all()
    {
       return Channel::all();
    }



    /**
     * Create Channel
     * @param Request $request
     */
    public function create($name)
    {
        Channel::create([
            'name' => $name,
            'slug' => Str::slug($name),
        ]);
    }

    /**
     * Update Channel
     * @param Request $request
     */
    public function update($request)
    {
        Channel::find($request->id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
    }


    /**
     * Delete Channel(s)
     * @param Request $request
     */
    public function delete($id)
    {
        Channel::destroy($id);
    }

}


?>
