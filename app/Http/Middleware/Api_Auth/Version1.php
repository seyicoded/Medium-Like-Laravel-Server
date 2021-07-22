<?php

namespace App\Http\Middleware\Api_Auth;

use Closure;

use Illuminate\Support\Facades\DB;

class Version1
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
        $api_key = $request->api_key;
        $data = DB::select('SELECT * from api_route_key where version = ?', [1]);
        if(count($data) == 0){
            return response()->json(['status'=>false, 'message'=>'api key invalid'],200);
        }

        if( ($data[0]->key_value) != ($api_key)){
            return response()->json(['status'=>false, 'message'=>'api key invalid'],200);
        }
        return $next($request);
    }
}
