<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('instructions', function (Blueprint $table) {
            $table->string('icon_path')->nullable();
        });
    }

    public function down()
    {
        Schema::table('instructions', function (Blueprint $table) {
            $table->dropColumn('icon_path');
        });
    }
};
