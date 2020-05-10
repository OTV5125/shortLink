<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            $shortLink = new ShortLink;
            $data = [
                'user_id' => Auth::user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'url' => $request->url,
                'image' => $request->image,
            ];
            $code = $shortLink->addRecord($data);
            echo json_encode(['status' => 'success', 'code' => $code]);
        }
        die;
    }

    public function link($code){
        $meta = ShortLink::select('url', 'title', 'image', 'description')->where('code', $code)->first();
        if(!is_null($meta)){
            if(isset($meta->image)) $meta->image = asset('storage/images/'.$meta->image);
            return view('link')->with('meta', $meta->toarray());
        }
        return view('link');
    }
}
