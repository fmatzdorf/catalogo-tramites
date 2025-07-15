<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
     {
         // Create initial admin user
         /*User::firstOrCreate(
             ['email' => 'admin@localhost'],
             [
                 'name' => 'Admin',
                 'email' => 'admin@localhost',
                 'password' => Hash::make('Xem2zZnkrM3Dxvgy'),
                 'role' => 'admin',
                 'institution_id' => null,
                 'email_verified_at' => now(),
             ]
         );*/

         // Create additional test users if needed
         if (app()->environment('local')) {
             // Create test institutional user (will need to be assigned to an institution after institutions are created)
             User::firstOrCreate(
                 ['email' => 'test@localhost'],
                 [
                     'name' => 'Test User',
                     'email' => 'institutional@localhost',
                     'password' => Hash::make('testing'),
                     'role' => 'institutional',
                     'institution_id' => null, // Will be updated after institutions are created
                     'email_verified_at' => now(),
                 ]
             );

             // Create additional test admin
             /*User::firstOrCreate(
                 ['email' => 'testadmin@example.com'],
                 [
                     'name' => 'Test Admin',
                     'email' => 'testadmin@example.com',
                     'password' => Hash::make('password'),
                     'role' => 'admin',
                     'institution_id' => null,
                     'email_verified_at' => now(),
                 ]
             );*/
        }
    }
}
