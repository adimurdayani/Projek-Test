<?php namespace App\Services;
      use App\Models\ModuleRole;

class AuthorizationService
{
  /**
   * For save all modules
   *
   */
  public static $modules = FALSE;

  /**
   * Get module allowed
   *
   */
  private function get_module()
  {
    if (!self::$modules) {
      self::$modules = ModuleRole::query()->with("module")->where("role_id", auth()->user()->role_id)->get();
    }
  }

  /**
   * Check authorization
   *
   * @param string $module_code
   */
  public function check_authorization($module_code)
  {
    $allow = TRUE;

    if (auth()->user()->role_id > 1) {
      $this->get_module();
      $list_module_code = self::$modules->pluck("module.module_code")->toArray();

      $explode_and = explode("&", $module_code);
      $explode_or = explode("|", $module_code);

      if (count($explode_and) > 1) {
        $allow = TRUE;

        foreach ($explode_and as $module_code) {
          if (!in_array($module_code, $list_module_code)) {
            $allow = FALSE;
            break;
          }
        }
      } else if (count($explode_or) > 1) {
        $allow = FALSE;

        foreach ($explode_or as $module_code) {
          if (in_array($module_code, $list_module_code)) {
            $allow = TRUE;
            break;
          }
        }
      } else {
        $allow = in_array($module_code, $list_module_code);
      }
    }

    return $allow;
  }
}
