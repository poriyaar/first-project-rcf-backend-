<?php

namespace App\Models;

use App\Models\User;
use App\Models\Answer;
use App\Models\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thread extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**************************************** */
    /***********start relation*************** */
    /**************************************** */

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
