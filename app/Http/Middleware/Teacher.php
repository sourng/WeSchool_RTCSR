<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Teacher
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
        if(Auth::User()->user_type != 'Teacher'){
            return back()->with('error',_lang('You dont have permission to access this feature !'));
        }
        return $next($request);
    }
}
