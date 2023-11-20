<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
      if (Auth::guard('supplier')->guest()){
          return  response()->json([
              'status'=>false,
              'message'=>'unauthorized'
          ],401);
      }
        return $next($request);
    }
}
