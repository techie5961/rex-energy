<?php

namespace App\Http\Middleware;

use App\Helpers\CurrencyHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Nette\Utils\Helpers;
use PHPUnit\TextUI\Help;

class UsersDashboardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::guard('users')->check()){
                return redirect('users/login');
        }
         View::share('currency','₦');
         View::share('CurrencyHelper',CurrencyHelper::class);
         View::share('display_currency',Auth::guard('users')->user()->display_currency);
        return $next($request);
    }
}
