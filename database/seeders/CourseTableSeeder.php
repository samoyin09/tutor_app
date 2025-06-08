<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('courses')->delete(); // Clears the courses table before seeding

        $now = Carbon::now();

        DB::table('courses')->insert([
            ['name' => 'Social Studies', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'General Science', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'English Language', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Mathematice', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Biology', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Chemistry', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Physics', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'History', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Geography', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Computer Science', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Economics', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Government', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
