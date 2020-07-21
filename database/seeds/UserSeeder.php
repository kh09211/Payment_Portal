<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Admin',
            'email' => env('ADMIN_EMAIL'),
            'password' => env('ADMIN_PASS_HASH')]);

        \App\User::create([
            'name' => env('TEST_USER_NAME'),
            'email' => env('TEST_USER_EMAIL'),
            'password' => env('TEST_USER_PASS_HASH')]);
    }
}
