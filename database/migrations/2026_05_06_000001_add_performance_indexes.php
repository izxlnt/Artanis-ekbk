<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerformanceIndexes extends Migration
{
    public function up()
    {
        // batches: (shuttle_id, tahun, bulan) covers form-per-month lookups and JOIN conditions
        Schema::table('batches', function (Blueprint $table) {
            $table->index(['shuttle_id', 'tahun', 'bulan'], 'batches_shuttle_tahun_bulan_idx');
            $table->index('status', 'batches_status_idx');
            $table->index('tahun', 'batches_tahun_idx');
        });

        // form_a_s: (shuttle_id, tahun) covers IBK dashboard and registration-year counts
        Schema::table('form_a_s', function (Blueprint $table) {
            $table->index(['shuttle_id', 'tahun'], 'form_a_s_shuttle_tahun_idx');
            $table->index('tahun', 'form_a_s_tahun_idx');
            $table->index('status', 'form_a_s_status_idx');
        });

        // formbs: (shuttle_id, tahun, suku_tahun) covers quarterly form lookups; tahun alone for bulk loads
        Schema::table('formbs', function (Blueprint $table) {
            $table->index(['shuttle_id', 'tahun', 'suku_tahun'], 'formbs_shuttle_tahun_suku_idx');
            $table->index('tahun', 'formbs_tahun_idx');
            $table->index('status', 'formbs_status_idx');
        });

        // form_c_s: (shuttle_id, tahun, bulan) covers monthly form lookups; tahun alone for bulk loads
        Schema::table('form_c_s', function (Blueprint $table) {
            $table->index(['shuttle_id', 'tahun', 'bulan'], 'form_c_s_shuttle_tahun_bulan_idx');
            $table->index('tahun', 'form_c_s_tahun_idx');
            $table->index('status', 'form_c_s_status_idx');
        });

        // form_d_s: shuttle 3 monthly D forms
        Schema::table('form_d_s', function (Blueprint $table) {
            $table->index(['shuttle_id', 'tahun', 'bulan'], 'form_d_s_shuttle_tahun_bulan_idx');
            $table->index('tahun', 'form_d_s_tahun_idx');
            $table->index('status', 'form_d_s_status_idx');
        });

        // form4_d_s: shuttle 4 monthly D forms
        Schema::table('form4_d_s', function (Blueprint $table) {
            $table->index(['shuttle_id', 'tahun', 'bulan'], 'form4_d_s_shuttle_tahun_bulan_idx');
            $table->index('tahun', 'form4_d_s_tahun_idx');
            $table->index('status', 'form4_d_s_status_idx');
        });

        // form4_e_s: shuttle 4 monthly E forms
        Schema::table('form4_e_s', function (Blueprint $table) {
            $table->index(['shuttle_id', 'tahun', 'bulan'], 'form4_e_s_shuttle_tahun_bulan_idx');
            $table->index('tahun', 'form4_e_s_tahun_idx');
            $table->index('status', 'form4_e_s_status_idx');
        });

        // form5_d_s: shuttle 5 monthly D forms
        Schema::table('form5_d_s', function (Blueprint $table) {
            $table->index(['shuttle_id', 'tahun', 'bulan'], 'form5_d_s_shuttle_tahun_bulan_idx');
            $table->index('tahun', 'form5_d_s_tahun_idx');
            $table->index('status', 'form5_d_s_status_idx');
        });

        // form5_e_s: shuttle 5 monthly E forms
        Schema::table('form5_e_s', function (Blueprint $table) {
            $table->index(['shuttle_id', 'tahun', 'bulan'], 'form5_e_s_shuttle_tahun_bulan_idx');
            $table->index('tahun', 'form5_e_s_tahun_idx');
            $table->index('status', 'form5_e_s_status_idx');
        });

        // shuttles: (shuttle_type, negeri_id) and (shuttle_type, daerah_id) for filtered list queries
        Schema::table('shuttles', function (Blueprint $table) {
            $table->index(['shuttle_type', 'negeri_id'], 'shuttles_type_negeri_idx');
            $table->index(['shuttle_type', 'daerah_id'], 'shuttles_type_daerah_idx');
        });

        // users: (shuttle_type, is_approved) for dashboard count queries
        Schema::table('users', function (Blueprint $table) {
            $table->index(['shuttle_type', 'is_approved'], 'users_shuttle_type_approved_idx');
        });
    }

    public function down()
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropIndex('batches_shuttle_tahun_bulan_idx');
            $table->dropIndex('batches_status_idx');
            $table->dropIndex('batches_tahun_idx');
        });

        Schema::table('form_a_s', function (Blueprint $table) {
            $table->dropIndex('form_a_s_shuttle_tahun_idx');
            $table->dropIndex('form_a_s_tahun_idx');
            $table->dropIndex('form_a_s_status_idx');
        });

        Schema::table('formbs', function (Blueprint $table) {
            $table->dropIndex('formbs_shuttle_tahun_suku_idx');
            $table->dropIndex('formbs_tahun_idx');
            $table->dropIndex('formbs_status_idx');
        });

        Schema::table('form_c_s', function (Blueprint $table) {
            $table->dropIndex('form_c_s_shuttle_tahun_bulan_idx');
            $table->dropIndex('form_c_s_tahun_idx');
            $table->dropIndex('form_c_s_status_idx');
        });

        Schema::table('form_d_s', function (Blueprint $table) {
            $table->dropIndex('form_d_s_shuttle_tahun_bulan_idx');
            $table->dropIndex('form_d_s_tahun_idx');
            $table->dropIndex('form_d_s_status_idx');
        });

        Schema::table('form4_d_s', function (Blueprint $table) {
            $table->dropIndex('form4_d_s_shuttle_tahun_bulan_idx');
            $table->dropIndex('form4_d_s_tahun_idx');
            $table->dropIndex('form4_d_s_status_idx');
        });

        Schema::table('form4_e_s', function (Blueprint $table) {
            $table->dropIndex('form4_e_s_shuttle_tahun_bulan_idx');
            $table->dropIndex('form4_e_s_tahun_idx');
            $table->dropIndex('form4_e_s_status_idx');
        });

        Schema::table('form5_d_s', function (Blueprint $table) {
            $table->dropIndex('form5_d_s_shuttle_tahun_bulan_idx');
            $table->dropIndex('form5_d_s_tahun_idx');
            $table->dropIndex('form5_d_s_status_idx');
        });

        Schema::table('form5_e_s', function (Blueprint $table) {
            $table->dropIndex('form5_e_s_shuttle_tahun_bulan_idx');
            $table->dropIndex('form5_e_s_tahun_idx');
            $table->dropIndex('form5_e_s_status_idx');
        });

        Schema::table('shuttles', function (Blueprint $table) {
            $table->dropIndex('shuttles_type_negeri_idx');
            $table->dropIndex('shuttles_type_daerah_idx');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_shuttle_type_approved_idx');
        });
    }
}
