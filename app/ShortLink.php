<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Service;

class ShortLink extends Model
{
    protected $table = 'short_link';
    public $timestamps = false;
    protected $fillable = array('user_id', 'url', 'title', 'description', 'image', 'code');

    public function addRecord($param){
        $result = ShortLink::select('id', 'code')->orderBy('id', 'desc')->first();

        if(is_null($result)){
            $lastCode = null;
            $id = 1;
        }else{
            $lastCode = $result->code;
            $id = ++$result->id;
        }
        $code = Service::generateCode($lastCode, -1);
        $image = $param['image'];
        $param['image'] = $id.'.'.$image->getClientOriginalExtension();
        $param['code'] = $code;
        self::create($param);
        $image->storeAs('public/images', $param['image']);
        return $code;
    }
}
