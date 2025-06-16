<?php

namespace Database\Factories;

use App\Models\Leaves;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeavesFactory extends Factory
{
    protected $model = Leaves::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'reason' => $this->faker->sentence,
            'status' => 'pending',
        ];
    }
}
