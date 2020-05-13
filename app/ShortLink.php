<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    protected $table = 'short_link';
    public $timestamps = false;
    protected $fillable = ['user_id', 'url', 'title', 'description', 'image', 'code'];
    public $columnName = ['url', 'title', 'description', 'image'];

    public function getLastCode()
    {
        return ShortLink::select('id', 'code')->orderBy('id', 'desc')->first();
    }

    public function link($code)
    {
        $result = call_user_func(array($this, 'select'), $this->columnName)->where('code', $code)->first();
        if (is_null($result)) {
            return false;
        } else {
            return $result->toarray();
        }
    }
}
