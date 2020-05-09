<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\ShortLink;

class WelcomeController extends Controller
{
    public function index(){
        if(is_null(Auth::user())){
            return view('welcome');
        }else{
            $links = ShortLink::where('user_id', '=', Auth::user()->id)->get();
            $fullUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            return view('welcome')->with('result', ['links' => $links, 'fullUrl' => $fullUrl]);
        }
    }
}
