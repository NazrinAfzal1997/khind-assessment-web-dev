<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::find(1);
        Student::insert([
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'address' => '123 Main St, Cityville',
                'program_id' => 1, // Assuming program_id 1 exists
                'registration_number' => 'REG123456',
                'contact_number' => '0123456789',
                'start_program_date' => Carbon::now()->subMonth()->toDateString(),  // 1 month ago
                'end_program_date' => Carbon::now()->addYear()->toDateString(),    // 1 year later
                'created_by' => $admin->id,
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'address' => '456 Elm St, Townsville',
                'program_id' => 2, // Assuming program_id 2 exists
                'registration_number' => 'REG123457',
                'contact_number' => '0123456790',
                'start_program_date' => Carbon::now()->subWeek()->toDateString(),  // 1 week ago
                'end_program_date' => Carbon::now()->addYear()->toDateString(),
                'created_by' => $admin->id,
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'address' => '789 Oak St, Villagetown',
                'program_id' => 1, // Assuming program_id 1 exists
                'registration_number' => 'REG123458',
                'contact_number' => '0123456791',
                'start_program_date' => Carbon::now()->subDay()->toDateString(),  // 1 day ago
                'end_program_date' => Carbon::now()->addYear()->toDateString(),
                'created_by' => $admin->id,
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Brown',
                'address' => '101 Pine St, Metropolis',
                'program_id' => 3, // Assuming program_id 3 exists
                'registration_number' => 'REG123459',
                'contact_number' => '0123456792',
                'start_program_date' => Carbon::now()->subMonth()->toDateString(),
                'end_program_date' => Carbon::now()->addYear()->toDateString(),
                'created_by' => $admin->id,
            ],
            [
                'first_name' => 'Chris',
                'last_name' => 'Davis',
                'address' => '202 Cedar St, Cityopolis',
                'program_id' => 2, // Assuming program_id 2 exists
                'registration_number' => 'REG123460',
                'contact_number' => '0123456793',
                'start_program_date' => Carbon::now()->subYear()->toDateString(),  // 1 year ago
                'end_program_date' => Carbon::now()->addYear()->toDateString(),
                'created_by' => $admin->id,
            ]
        ]);
    }
}
