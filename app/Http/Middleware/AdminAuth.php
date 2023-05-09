<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;

class AdminAuth 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (isset($request->token) && $request->token != null)
        {
            $admin = Admin::where('token', $request->token)->first();
            if($admin != null)
                return $next($request);
        }
        return response()->json([
            'error' => 'Unauthenticate Admin'
            ], 
            401);          
    }
}
