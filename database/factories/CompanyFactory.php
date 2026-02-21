<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company_name' => $this->faker->company,
            'website' => $this->faker->url,
            'location' => $this->faker->city,
            'about' => $this->faker->paragraph,
        ];
    }
}
