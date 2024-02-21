<?php

namespace App\Http\Middleware;

use App\Models\SessionToken;
use Closure;
use Illuminate\Http\Request;

class CheckSessionToken
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
    if (auth()->check()) {
      $session_token = session("session_token");
      $check_valid_token = SessionToken::query()->where("is_login", 1)->where("session_token", $session_token)->where("expire_time", ">", date("Y-m-d H:i:s"))->exists();

      if ($check_valid_token) {
        $expire_time = date("Y-m-d H:i:s", strtotime("+15minute"));
        SessionToken::query()->where("session_token", $session_token)->update([
          "active_time" => date("Y-m-d H:i:s"),
          "expire_time" => $expire_time
        ]);

        return $next($request);
      }

      session()->flash("message", "<script>CORE.sweet('warning', 'Sesi Habis!', 'Waktu sesi anda telah habis, silahkan login kembali!')</script>");
      SessionToken::query()->where("session_token", $session_token)->delete();
    }

    return redirect()->to("/login");
  }
}
