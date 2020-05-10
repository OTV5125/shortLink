<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Service;
use App\ShortLink;
use Auth;
use Validator;


class UrlController extends Controller
{
    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'url' => 'max:255|required|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'image' => 'required|mimes:jpeg,jpg,bmp,png,gif|max:5000'
        ]);
        if ($validator->fails()) {
            echo json_encode($validator->messages());
        }
        else{
            $lastCode = ShortLink::select('code')->orderBy('id', 'desc')->first();
            $lastCode = (!is_null($lastCode))?$lastCode->code:null;
            $code = Service::generateCode($lastCode, -1);
            $shortLink = new ShortLink;
            $shortLink->user_id = Auth::user()->id;
            $shortLink->url = $request->url;
            $shortLink->title = $request->title;
            $shortLink->description = $request->description;
            $shortLink->code = $code;
            $shortLink->save();
            $id = $shortLink->id;
            $fileName = $id.'.'.$request->image->getClientOriginalExtension();
            $shortLink = $shortLink::find($shortLink->id);
            $shortLink->image = $fileName;
            $shortLink->save();
            $request->image->storeAs('public', $fileName);
            echo json_encode(['status' => 'success', 'code' => $code]);
        }
        die;
    }

    public function link($code){
        $meta = ShortLink::select('url', 'title', 'image', 'description')->where('code', $code)->first();
        if(!is_null($meta)){
            return view('link')->with('meta', $meta->toarray());
        }
        return view('link');
    }
}
