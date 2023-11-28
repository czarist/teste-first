<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name'  => null,
            'fname' => 'admin',
            'lname' => 'admin',
            'email' => 'admin@admin.com',
            'role' => 4,
            'phone' => '(51) 98659-3952',
            'password' => Hash::make('admin@123')
        ]);

        \App\Models\User::factory()->create([
            'name'  => null,
            'fname' => 'Lucas',
            'lname' => 'Cezar',
            'email' => 'teste@gmail.com',
            'role' => 1,
            'phone' => '(51) 98659-3952',
            'password' => Hash::make('admin@123')
        ]);

        \App\Models\User::factory()->create([
            'name'  => null,
            'fname' => 'Ricardo',
            'lname' => 'Gomes',
            'email' => 'ricardogomes@gmail.com',
            'role' => 1,
            'phone' => '(51) 98659-3952',
            'password' => Hash::make('admin@123')
        ]);

        \App\Models\User::factory()->create([
            'name'  => null,
            'fname' => 'Rogério',
            'lname' => 'Gomes',
            'email' => 'gomes@gmail.com',
            'role' => 1,
            'phone' => '(51) 98659-3952',
            'password' => Hash::make('admin@123')
        ]);


        // run on terminal: php artisan db:seed --force
    }
}
