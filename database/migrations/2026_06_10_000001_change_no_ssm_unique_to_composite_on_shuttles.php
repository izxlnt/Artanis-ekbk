<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNoSsmUniqueToCompositeOnShuttles extends Migration
{
    public function up()
    {
        Schema::table('shuttles', function (Blueprint $table) {
            $table->dropUnique('shuttles_no_ssm_unique');
            $table->unique(['no_ssm', 'shuttle_type'], 'shuttles_no_ssm_shuttle_type_unique');
        });
    }

    public function down()
    {
        Schema::table('shuttles', function (Blueprint $table) {
            $table->dropUnique('shuttles_no_ssm_shuttle_type_unique');
            $table->unique('no_ssm', 'shuttles_no_ssm_unique');
        });
    }
}
