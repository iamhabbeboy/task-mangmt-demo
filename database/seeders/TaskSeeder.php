<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Task::factory()
//            ->count(10)
//            ->create();
        Project::create([
            'name' => 'Coding',
        ]);

        Project::create([
            'name' => 'Chores',
        ]);

        Task::create([
            'name' => 'Complete XYZ project',
            'priority' => 1,
            'project_id' => 1
        ]);

        Task::create([
            'name' => 'Refactor Zoom core',
            'priority' => 2,
            'project_id' => 1
        ]);

        Task::create([
            'name' => 'Implement payment',
            'priority' => 3,
            'project_id' => 1
        ]);

        Task::create([
            'name' => 'Clean the desk',
            'priority' => 1,
            'project_id' => 2
        ]);

        Task::create([
            'name' => 'Mob the floor',
            'priority' => 2,
            'project_id' => 2
        ]);

    }
}
