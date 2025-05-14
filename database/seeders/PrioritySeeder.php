<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            ['key' => 'low', 'label' => 'Low', 'color' => '#00B894'],
            ['key' => 'medium', 'label' => 'Medium', 'color' => '#FDCB6E'],
            ['key' => 'high', 'label' => 'High', 'color' => '#D63031'],
        ];

        foreach ($priorities as $priority) {
            Priority::create($priority);
        }
    }
}
