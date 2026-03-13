<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\Employee;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(OrganizationSeeder::class);
        $divisions = Division::all();
        $divisionCount = $divisions->count();

        $roleCounts = [
            'admin'=>5,
            'dispatcher'=>5,
            'worker'=>40,
            'supervisor'=>10,
            'citizen'=>5
            ];

        foreach($roleCounts as $role => $count){
            for($i = 1;$i <= $count;$i++){
                $user = User::factory()->create([
                    'name' => ucfirst($role) . ' ' . $i,
                    'email' => $role . $i . '@gmail.com',
                    'role' => $role
                ]);

                if(in_array($role,['worker','supervisor'])){
                    $assignedDivision = $divisions[$i % $divisionCount];

                    Employee::create([
                        'user_id' => $user->id,
                        'division_id' => $assignedDivision->id,
                        'job_title' => $role === 'supervisor' ? 'Division Supervisor' : 'Field Technician',
                    ]);
                }
            }
        }
        $this->command->info('Users and Employees seeded successfully! (including 40 Workers & 10 Supervisors)');
    }
}
