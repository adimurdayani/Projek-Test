<?php namespace App\Services\Cores;

use Illuminate\Support\Facades\DB;

class BaseService
{
  protected static $count_transaction = 0;
  protected static $trans_exists = FALSE;
  protected static $refresh_token = FALSE;

  public function trans_begin()
  {
    if (static::$trans_exists == FALSE) {
      DB::beginTransaction();
    }

    static::$trans_exists = TRUE;
    static::$count_transaction++;
  }

  public function trans_rollback()
  {
    if (static::$trans_exists == TRUE && static::$count_transaction > 0) {
      static::$count_transaction--;
      if (static::$count_transaction <= 0) {
        DB::rollBack();
        static::$trans_exists = FALSE;
      }
    }
  }

  public function trans_commit()
  {
    if (static::$trans_exists == TRUE && static::$count_transaction > 0) {
      static::$count_transaction--;
      if (static::$count_transaction <= 0) {
        DB::commit();
        static::$trans_exists = FALSE;
      }
    }
  }
}