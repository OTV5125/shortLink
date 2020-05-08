<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Code;
use App\ShortLink;
use Auth;
use Validator;


class AddUrlController extends Controller
{
    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'url' => 'required|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'image' => 'required|mimes:jpeg,jpg,bmp,png|max:5000'
        ]);
        if ($validator->fails())
        {var_dump($validator->messages());}
        else{
            $lastCode = ShortLink::orderBy('id', 'desc')->first();
            $lastCode = (!is_null($lastCode))?$lastCode->code:null;
            $shortLink = new ShortLink;
            $shortLink->user_id = 1;
            $shortLink->url = $request->url;
            $shortLink->title = $request->title;
            $shortLink->description = $request->description;
            $shortLink->code = Code::generateCode($lastCode, -1);
            $shortLink->save();
            $id = $shortLink->id;
            $fileName = $id.'.'.$request->image->getClientOriginalExtension();
            $shortLink = $shortLink::find($shortLink->id);
            $shortLink->image = $fileName;
            $shortLink->save();
            $request->image->storeAs('public', $fileName);
        }
        die;

    }
}
