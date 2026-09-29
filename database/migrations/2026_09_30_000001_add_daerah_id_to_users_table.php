<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Schema only: add a nullable users.daerah_id so a user can be linked to a
 * district by id instead of by the free-text users.daerah.
 *
 * The column is additive and starts empty, and the app falls back to the old
 * name lookup while it is empty, so this is safe to run and safe to roll back
 * (down() only drops the new column and touches no other data). Filling it
 * in, and any data corrections, live in
 * Database\Seeders\FixDaerahIntegritySeeder.
 *
 * users.daerah stays as the district name for display and legacy lookups.
 */
class AddDaerahIdToUsersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('users', 'daerah_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('daerah_id')->nullable()->after('daerah')->index();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('users', 'daerah_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('daerah_id');
            });
        }
    }
}
