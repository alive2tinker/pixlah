<?php

namespace Database\Factories;

use App\Models\Screen;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScreenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Screen::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'location' => $this->faker->word,
            'user_id' => 1,
            'color_1' => '#106eaf',
            'color_2' => '#1fa496',
            'color_3' => '',
        ];
    }
}
