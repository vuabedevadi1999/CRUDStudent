<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create()->each(function($user){
            $roleStudent = Role::where('name','Student')->first();
            $roleAdmin = Role::where('name','Admin')->first();
            $roleId = [$roleStudent->id,$roleAdmin->id];
            $user->roles()->attach($roleId[rand(0,1)]);
        });
        // \App\Models\Student::factory(20)->create();
    }
}
