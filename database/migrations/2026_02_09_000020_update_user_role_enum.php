<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->where('role', 'dj')->update(['role' => 'staff']);

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','staff','corp_member','intern','user') DEFAULT 'user'");
    }

    public function down(): void
    {
        DB::table('users')
            ->whereIn('role', ['corp_member', 'intern'])
            ->update(['role' => 'user']);

        DB::table('users')->where('role', 'staff')->update(['role' => 'dj']);

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','dj','user') DEFAULT 'user'");
    }
};
