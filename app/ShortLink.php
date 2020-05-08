<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    protected $table = 'short_link';
    public $timestamps = false;
    protected $guarded = array('user_id', 'url', 'title', 'description', 'image', 'code');
}
