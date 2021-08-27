<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $statuses = ['waiting', 'serving','served'];

        return [
            'number' => $this->faker->numberBetween(1000,9999),
            'status' => 'waiting',
            'screen_id' => 1
        ];
    }
}
