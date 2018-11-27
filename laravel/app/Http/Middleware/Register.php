<?php

namespace App\Http\Middleware;

use App\Model\User;
use Closure;

class Register
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
        if($request->get('delivery_is_actual') && $request->get('type') == User::JURIDICAL_TYPE){

            $request->request->set('juridical_delivery_address', $request->get('actual_address'));
            $request->request->set('delivery_addresses', [ 0 => $request->get('actual_address')]);

        }

        return $next($request);
    }
}
