<?php namespace App\Services\Auth;

use App\Models\ProjectSetting;
use App\Models\SessionToken;
use App\Models\User;
use App\Services\Cores\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginService extends BaseService
{
  /**
   * Create a session token
   *
   * @param int $user_id
   */
  private function create_session_token($user_id)
  {
    do {
      $token = random_string(20);
      $check_exists = SessionToken::query()->where("session_token", $token)->exists();
    } while ($check_exists);

    SessionToken::create([
      "user_id" => $user_id,
      "session_token" => $token,
      "active_time" => date("Y-m-d H:i:s"),
      "expire_time" => date("Y-m-d H:i:s", strtotime("+15minute")),
      "is_login" => 1
    ]);

    session(["session_token" => $token]);
  }

  /**
   * Check login multi device
   *
   * @param int $user_id
   * @return bool
   */
  private function check_multi_login($user_id)
  {
    $check_allow_multi_login = ProjectSetting::query()->where("multi_login_device", 1)->exists();

    if (!$check_allow_multi_login) {
      $get_user_login = SessionToken::query()->where("user_id", $user_id)->where("is_login", 1)->where("expire_time", ">", date("Y-m-d H:i:s"))->exists();

      if ($get_user_login) {
        return FALSE;
      }
    }

    return TRUE;
  }

  /**
   * Store login
   *
   * @param Request $request
   */
  public function login(Request $request)
  {
    $response = \create_response();

    $get_user = User::where(function($query) use ($request) {
      $query->where("email", $request->email)->orWhere("username", $request->email);
    })
    ->whereNotNull("username")
    ->first();

    if ($get_user) {
      if (Hash::check($request->password, $get_user->password)) {
        $check_multi_login = $this->check_multi_login($get_user->id);

        if ($check_multi_login) {
          $remember = $request->has("remember_me");
          Auth::loginUsingId($get_user->id, $remember);

          $this->create_session_token($get_user->id);
          $response->status = TRUE;
          $response->status_code = 200;
          $response->message = "Success!";
          $response->next_url = \route("app.dashboard");
        } else {
          $response->message = "Saat ini user sedang login pada perangkat lain!";
          $response->status_code = 403;
        }
      } else {
        $response->message = "Password salah!";
        $response->status_code = 403;
      }
    } else {
      $response->message = "User tidak ditemukan!";
      $response->status_code = 403;
    }

    return $response;
  }
}
