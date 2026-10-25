<?php

namespace Database\Seeders;

use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HabitSeeder extends Seeder
{
    public function run(): void
    {
        $habits = [
            [
                'name' => 'Minum 2 Liter Air',
                'description' => 'Menjaga tubuh tetap terhidrasi sepanjang hari',
                'icon' => '💧',
                'color' => '#0ea5e9',
                'target_per_day' => 1,
            ],
            [
                'name' => 'Membaca Buku 15 Menit',
                'description' => 'Membaca buku non-fiksi / pengembangan diri',
                'icon' => '📖',
                'color' => '#8b5cf6',
                'target_per_day' => 1,
            ],
            [
                'name' => 'Olahraga & Stretching',
                'description' => 'Stretching pagi atau workout ringan 20 menit',
                'icon' => '🏃‍♂️',
                'color' => '#10b981',
                'target_per_day' => 1,
            ],
            [
                'name' => 'Meditasi & Jurnal Harian',
                'description' => 'Refleksi hari dan bersyukur 5 menit',
                'icon' => '🧘',
                'color' => '#f59e0b',
                'target_per_day' => 1,
            ],
            [
                'name' => 'Belajar Coding / Skill Baru',
                'description' => 'Praktik hands-on coding 30 menit',
                'icon' => '💻',
                'color' => '#ec4899',
                'target_per_day' => 1,
            ],
        ];

        foreach ($habits as $data) {
            $habit = Habit::firstOrCreate(
                ['name' => $data['name']],
                $data
            );

            // Buat history streak beberapa hari ke belakang untuk demo
            for ($i = 3; $i >= 1; $i--) {
                HabitLog::firstOrCreate(
                    [
                        'habit_id' => $habit->id,
                        'date' => Carbon::today()->subDays($i)->toDateString(),
                    ],
                    [
                        'count' => 1,
                        'completed' => true,
                    ]
                );
            }
        }
    }
}
