<?php

namespace App\Http\Middleware;

use Closure;

class RequestOrderModify
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

        if($request->get('coincides_company_name')){
            $request->request->set('company_receiver', $request->get('company_name'));
        }


        $request->request->set('organization', $request->get('company_name'));


        return $next($request);
    }
}
