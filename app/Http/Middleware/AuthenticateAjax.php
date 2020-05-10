<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthenticateAjax
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $error = [];

        if(!$request->ajax()){
            $error[] = 'is not ajax';
        }

        if(is_null(Auth::user())) {
            $error[] = 'not auth';
        }

        if(!empty($error)){
            echo json_encode($error);
            die;
        }else{
            return $next($request);
        }
    }
}
