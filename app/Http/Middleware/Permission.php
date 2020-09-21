<?php

namespace App\Http\Middleware;

use Illuminate\Http\Response;
use Closure;
use Auth;

class Permission
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
		$route_name = \Request::route()->getName();
		
		if( $route_name != "" && Auth::User()->user_type != 'Admin'){
			if(explode(".",$route_name)[1] == "update"){
				$route_name = explode(".",$route_name)[0].".edit";
			}else if(explode(".",$route_name)[1] == "store"){
				$route_name = explode(".",$route_name)[0].".create";
			}
			if( ! has_permission($route_name,Auth::User()->role_id)){
				if( ! $request->ajax()){
				   return back()->with('error',_lang('Sorry, You dont have permission to perform this action !'));
			    }else{
					return new Response('<h5 class="text-center red">'._lang('Sorry, You dont have permission to perform this action !').'</h5>');
				}
			}
		}
		
        /*
		if(Auth::User()->user_type != 'Admin'){
            return back()->with('error',_lang('You dont have permission to access this feature !'));
        }
		*/
        return $next($request);
    }
}
