<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->nullable()->after('id');
            }
            if (! Schema::hasColumn('users', 'nama_lengkap')) {
                $table->string('nama_lengkap')->nullable()->after('username');
            }
            if (! Schema::hasColumn('users', 'nip')) {
                $table->string('nip')->nullable()->after('nama_lengkap');
            }
            if (! Schema::hasColumn('users', 'nidn')) {
                $table->string('nidn')->nullable()->after('nip');
            }
            if (! Schema::hasColumn('users', 'kode_dosen')) {
                $table->string('kode_dosen')->nullable()->after('nidn');
            }
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('dosen wali')->after('kode_dosen');
            }
        });

        $exists = DB::table('users')
            ->where('email', 'admin@example.com')
            ->orWhere('username', 'admin')
            ->exists();

        if (! $exists) {
            DB::table('users')->insert([
                'username' => 'admin',
                'name' => 'Admin Sistem',
                'nama_lengkap' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('Password123!'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')
            ->where('email', 'admin@example.com')
            ->orWhere('username', 'admin')
            ->delete();

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'kode_dosen')) {
                $table->dropColumn('kode_dosen');
            }
            if (Schema::hasColumn('users', 'nidn')) {
                $table->dropColumn('nidn');
            }
            if (Schema::hasColumn('users', 'nip')) {
                $table->dropColumn('nip');
            }
            if (Schema::hasColumn('users', 'nama_lengkap')) {
                $table->dropColumn('nama_lengkap');
            }
            if (Schema::hasColumn('users', 'username')) {
                $table->dropUnique(['username']);
                $table->dropColumn('username');
            }
        });
    }
};
