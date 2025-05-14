<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $statuses = [
            ['key' => 'to_do', 'label' => 'To Do', 'color' => '#A4B0BE'],
            ['key' => 'in_progress', 'label' => 'In Progress', 'color' => '#FFA502'],
            ['key' => 'test', 'label' => 'Test', 'color' => '#1E90FF'],
            ['key' => 'done', 'label' => 'Done', 'color' => '#2ED573'],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
