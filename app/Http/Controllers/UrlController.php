<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShortLink;
use Auth;
use Validator;
use App\Services\Redis\RedisLink;
use Otv5125\Code\Code;

class UrlController extends Controller
{
    protected $pathToImage = 'storage/images/';

    public function add(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'url' => 'max:255|required|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'image' => 'required|mimes:jpeg,jpg,bmp,png,gif|max:5000'
        ]);
        if ($validator->fails()) {
            echo json_encode($validator->messages());
        } else {
            $shortLink = new ShortLink;
            $lastCode = $shortLink->getLastCode();
            if (is_null($lastCode)) {
                $lastCode = null;
                $id = 1;
            } else {
                $id = ++$lastCode->id;
                $lastCode = $lastCode->code;
            }

            $data = [
                'user_id' => Auth::user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'url' => $request->url,
                'image' => $id . '.' . $request->image->getClientOriginalExtension(),
                'code' => Code::generateCode($lastCode),
            ];
            try {
                ShortLink::create($data);
            } catch (\Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'insert database']);
                die;
            }
            $request->image->storeAs('public/images', $data['image']);
            echo json_encode(['status' => 'success', 'code' => $data['code']]);
        }
        die;
    }

    public function link($code)
    {
        $shortLink = new ShortLink;
        $redis = new RedisLink();
        $meta = $redis->getLink($code, $shortLink->columnName);
        if (!$meta) {
            $meta = $shortLink->link($code);
            if ($meta) {
                $redis->setLink($code, $meta);
            }
        }
        if (isset($meta['image'])) {
            $meta['image'] = asset($this->pathToImage . $meta['image']);
        }
        return (!$meta) ? view('link') : view('link')->with('meta', $meta);
    }
}
