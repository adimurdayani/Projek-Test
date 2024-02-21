<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleRole extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    /**
     * Relationship to modules
     *
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
