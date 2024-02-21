<?php namespace App\Supports;

class ResponseValidation
{
  /**
   * Return response fails validation
   * 
   * @param array $errors
   */
  public static function response($errors)
  {
    $response = \create_response();
    $response->status_code = 400;
    $response->message = "Validation Errors!";
    $response->data = $errors;


    return \response()->json($response, 400);
  }
}