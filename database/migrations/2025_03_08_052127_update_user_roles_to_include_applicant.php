<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateUserRolesToIncludeApplicant extends Migration
{
    public function up()
    {
        // **Step 1: Ensure all roles are valid before modifying ENUM**
        DB::table('users')->whereNull('role')->orWhere('role', '')->update(['role' => 'applicant']);

        DB::table('users')->whereNotIn('role', ['applicant', 'supervisor', 'processor', 'administrator', 'auditor'])
            ->update(['role' => 'applicant']);

        // **Step 2: Modify ENUM column**
        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE users CHANGE role role ENUM('applicant', 'supervisor', 'processor', 'administrator', 'auditor') NOT NULL DEFAULT 'applicant'");
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE users CHANGE role role ENUM('supervisor', 'processor', 'administrator', 'auditor') NOT NULL DEFAULT 'supervisor'");
        });
    }
}
