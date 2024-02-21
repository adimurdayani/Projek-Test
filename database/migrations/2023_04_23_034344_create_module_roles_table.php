<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId("module_id")->constrained()->restrictOnDelete();
            $table->foreignId("role_id")->constrained()->restrictOnDelete();
            $table->foreignId("user_assign")->references("id")->on("users")->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_roles');
    }
};
