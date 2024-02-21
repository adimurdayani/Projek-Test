<?php namespace App\Services\Cores;

class ErrorService
{
  /**
   * Capture error
   * 
   */
  public static function error(\Exception $e, $message)
  {
    \info($message, [
      "message" => $e->getMessage(),
      "trace" => $e->getTraceAsString()
    ]);
  }
}