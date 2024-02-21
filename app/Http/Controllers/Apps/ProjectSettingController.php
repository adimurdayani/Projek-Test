<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\ProjectSetting;
use Illuminate\Http\Request;

class ProjectSettingController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   */
  public function index()
  {
    $data = [
      "setting" => ProjectSetting::query()->first()
    ];
    return $this->view_admin("admin.project-settings.index", "Setting", $data, TRUE);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function update(Request $request)
  {
    ProjectSetting::query()->where("id", 1)->update([
      "multi_login_device" => $request->has("multi_login_device") ? 1 : 0,
      "is_maintenance" => $request->has("is_maintenance") ? 1 : 0,
    ]);

    $response = response_success_default("Berhasil update setting!", FALSE, route("app.settings.index"));
    return response_json($response);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
