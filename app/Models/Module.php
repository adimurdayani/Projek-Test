<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
  use HasFactory;
  protected $guarded = ["id"];

  public function roles()
  {
    return $this->hasMany(ModuleRole::class);
  }

  public function user_ass()
  {
    return $this->belongsToMany(User::class, ModuleRole::class, "id", "user_assign");
  }


}
