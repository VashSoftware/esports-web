<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OsuMessage extends Model
{
    protected $fillable = ['username', 'channel', 'message'];
}
