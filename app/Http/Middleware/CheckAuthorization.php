<?php

namespace App\Http\Middleware;

use App\Services\AuthorizationService;
use Closure;
use Illuminate\Http\Request;

class CheckAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next, $module_code)
    {
      if (auth()->check()) {
        $authorization_service = new AuthorizationService;

        if ($authorization_service->check_authorization($module_code)) {
          return $next($request);
        }

        if ($request->hasHeader("Accept") && $request->header("Accept") == "application/json") {
          return response()->json([
            "status" => FALSE,
            "message" => "Unauthorized",
            "status_code" => 403,
          ], 403);
        }

        return redirect()->to("/forbidden");
      }

      return redirect()->to("/login");
    }
}
