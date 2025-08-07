<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Country;
use App\Models\Currency;

class SetUserCurrency
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
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->country_id) {
                $country = Country::find($user->country_id);
                if ($country && $country->currency_code) {
                    $currency = Currency::where('name', $country->currency_code)->first();
                    if ($currency) {
                        Session::put('currency', $currency->id);
                    }
                }
            }
        }
        return $next($request);
    }
} 