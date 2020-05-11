<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
       //factory(User::class, 10)->create();
       \DB::table('users')->insert([
        'name' => 'Roberto Britz',
        'user_name' => 'britzbeto',
        'email' => 'roberto.britz@hotmail.com',
        'password' => bcrypt('123456')
         ]);
        \DB::table('users')->insert([
        'name' => 'Mateus Oliveira',
        'user_name' => 'Mateus',
        'email' => 'oliveira.mateusfelipe@gmail.com',
        'password' => bcrypt('123456')
        ]);
    }
}
