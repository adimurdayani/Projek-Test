<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  private UserService $user_service;

  public function __construct()
  {
    $this->user_service = new UserService;
  }

  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $data = [
      "admin_online" => $this->user_service->get_admin_online()
    ];

    return $this->view_admin("admin.index", "Dashboard", $data, TRUE);
  }
}
