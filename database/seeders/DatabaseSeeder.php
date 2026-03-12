<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $roles = ['admin','dispatcher','worker','supervisor','citizen'];

        foreach($roles as $role){
            for($i = 1;$i <= 5;$i++){
                User::factory()->create([
                    'name' => ucfirst($role) . ' ' . $i,
                    'email' => $role . $i . '@gmail.com',
                    'role' => $role
                ]);
            }
        }

        $this->call(OrganizationSeeder::class);
    }
}
