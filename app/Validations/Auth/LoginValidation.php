<?php namespace App\Validations\Auth;

use Illuminate\Support\Facades\Validator;

class LoginValidation 
{
  /**
   * Error check
   * 
   * @var bool $fails
   */
  private static $fails = FALSE;
  
  /**
   * Error results
   * 
   * @var array $fails
   */
  private static $errors = [];

  /**
   * Rules validation
   * 
   * @return array
   */
  private static function rules()
  {
    return [
      "email" => [
        "required", "string"
      ],
      "password" => [
        "required", "string", "min:6"
      ]
    ];
  }

  /**
   * Running validation
   * 
   */
  private static function run()
  {
    $run = Validator::make(\request()->all(), static::rules());
    static::$fails = $run->fails();
    static::$errors = $run->errors();
  }

  /**
   * Get errors
   * 
   */
  public static function errors()
  {
    return static::$errors;
  }
  
  /**
   * Get fails
   * 
   */
  public static function fails()
  {
    return static::$fails;
  }

  /**
   * Process check validation
   * 
   */
  public static function check()
  {
    static::run();
  }
}