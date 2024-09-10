<?php
namespace App\Http\Middleware;

use Closure;

class Cors{

    



    public function handel($request,Closure $next){
        return $next($request)
        ->header('Access-Control-Allow-Origin',"*")
        ->header('Access-Control-Allow-Methods',"PUT,POST,DELETE,GET,PATCH")
        ->header('Access-Control-Allow-Headers',"Accept,Authorization,Content-Type");

        

    }
}







