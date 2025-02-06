<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            ['code' => 'CS230', 'name' => 'Bachelor of Computer Science (Hons)'],
            ['code' => 'CS240', 'name' => 'Bachelor of Information Technology (Hons)'],
            ['code' => 'CS243', 'name' => 'Bachelor of Information Technology (Hons) Intelligent System Engineering'],
            ['code' => 'CS244', 'name' => 'Bachelor of Information Technology (Hons) Business Computing'],
            ['code' => 'CS245', 'name' => 'Bachelor of Computer Science (Hons) Data Communication and Networking'],
            ['code' => 'CS246', 'name' => 'Bachelor of Information Technology (Hons) Information System Engineering'],
            ['code' => 'CS251', 'name' => 'Bachelor of Computer Science (Hons) Netcentric Computing'],
            ['code' => 'CS253', 'name' => 'Bachelor of Computer Science (Hons) Multimedia Computing'],
        ];

        foreach ($programs as $program) {
            Program::create([
                'code' => $program['code'],
                'name' => $program['name'],
                'description' => $program['name'], // Setting description same as name
            ]);
        }
    }
}
