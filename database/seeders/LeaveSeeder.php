<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;


class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id')->toArray();

        foreach (range(1, 10) as $index) {
            $startDate = now()->addDays(rand(1, 10));
            $endDate = (clone $startDate)->addDays(rand(1, 3));

            DB::table('leaves')->insert([
                'user_id' => $userIds[array_rand($userIds)],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'reason' => 'Leave for personal reasons',
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}
