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
            return view('welcome')->with('result', ['links' => $links]);
        }
    }
}
