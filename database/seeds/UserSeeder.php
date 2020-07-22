<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // dd(config('app.test_password'));
        User::create(
            [
                'name' => 'Manuel Ojeda',
                'email' => 'mrdarkjeda@gmail.com',
                'password' => Hash::make(config('app.test_password')),
            ]
        );
    }
}
