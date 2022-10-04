<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'Admintrator'],
            ['name' => 'Subcriber']
        ];
        foreach ($roles as $role) {
            DB::table('roles')->insert($role);
        }
    }
}
