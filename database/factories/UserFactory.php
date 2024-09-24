<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = \App\Models\User::class; 

    public function definition()
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'nama_user' => $this->faker->name(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
