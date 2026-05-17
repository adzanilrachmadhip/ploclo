<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $users = [
            [
                'username' => 'kaprodi',
                'name' => 'Kaprodi Sistem',
                'nama_lengkap' => 'Kepala Program Studi',
                'email' => 'kaprodi@example.com',
                'password' => Hash::make('Kaprodi123!'),
                'role' => 'kaprodi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'dosenwali',
                'name' => 'Dosen Wali Sistem',
                'nama_lengkap' => 'Dosen Wali',
                'email' => 'dosenwali@example.com',
                'password' => Hash::make('DosenWali123!'),
                'role' => 'dosen wali',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            $exists = DB::table('users')
                ->where('email', $user['email'])
                ->orWhere('username', $user['username'])
                ->exists();

            if (! $exists) {
                DB::table('users')->insert($user);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')
            ->where('email', 'kaprodi@example.com')
            ->orWhere('username', 'kaprodi')
            ->delete();

        DB::table('users')
            ->where('email', 'dosenwali@example.com')
            ->orWhere('username', 'dosenwali')
            ->delete();
    }
};
