<?php

namespace App\Http\Middleware;

use App\Models\ProjectSetting;
use Closure;
use Illuminate\Http\Request;

class CheckMaintenance
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
        $check_maintenance = ProjectSetting::query()->where("is_maintenance", 0)->exists();

        if (!$check_maintenance && auth()->check() && auth()->user()->role_id != 1 && $request->route()->getName() != "maintenance") {
            return redirect()->route("maintenance");
        }

        if ($check_maintenance && $request->route()->getName() == "maintenance") {
            return redirect()->to("/login");
        }

        return $next($request);
    }
}
