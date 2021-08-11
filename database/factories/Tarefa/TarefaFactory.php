<?php

namespace Database\Factories\Tarefa;

use App\Models\Tarefa\Tarefa;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TarefaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tarefa::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => '1',
            'Tarefa' => $this->faker->text(10),
            'status' => $this->faker->boolean(),
            'prioridade' => $this->faker->numberBetween(1, 3),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
