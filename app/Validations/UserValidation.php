<?php namespace App\Validations;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserValidation
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
   * Values results
   * 
   * @var array $fails
   */
  private static $validated = [];

  /**
   * Running
   * 
   * @var array $fails
   */
  private static $run = FALSE;

  /**
   * Rules validation
   * 
   * @return array
   */
  private static function rules()
  {
    return [
      "role_id" => [
        "required", "exists:roles,id"
      ],
      "name" => [
        "required", "string"
      ],
      "email" => [
        "required", "email", \request()->method() == "POST" ? "unique:users,email" : Rule::unique("users", "email")->ignore(\request()->route("user")->id, "id")->whereNull("deleted_at")
      ],
      "username" => [
        "nullable", "string", request()->method() == "POST" ? "unique:users,username" : Rule::unique("users", "username")->ignore(\request()->route("user")->id, "id")->whereNull("deleted_at")
      ],
      "password" => [
        \request()->method() == "POST" ? "required" : "nullable", "string", "min:6"
      ]
    ];
  }

  /**
   * Running validation
   * 
   */
  private static function run()
  {
    // \dd(static::rules());
    static::$run = Validator::make(\request()->all(), static::rules());
    static::$fails = static::$run->fails();
    static::$errors = static::$run->errors();
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
  
  /**
   * Get values validated
   * 
   */
  public static function validated()
  {
    return static::$run->validated();
  }
}