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
            'email' => config('app.ADMIN_EMAIL'),
            'password' => config('app.ADMIN_PASS_HASH')]);

        \App\User::create([
            'name' => config('app.TEST_USER_NAME'),
            'email' => config('app.TEST_USER_EMAIL'),
            'password' => config('app.TEST_USER_PASS_HASH')]);
    }
}
