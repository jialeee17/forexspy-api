<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->unique()->uuid(),
            'username' => $this->faker->unique()->userName(),
            'password' => '$2y$10$UUCVP4kRkWn7oTnVOlS7PeYyYVg8kKGDC0anD4BIqE6hx8ZgDkmdG', // password: admin123,
            'email' => $this->faker->unique()->safeEmail(),
            'first_name' => $this->faker->firstNameMale(),
            'last_name' => $this->faker->lastName(),
            'profile_picture' => $this->faker->imageUrl(640, 480, 'animals', true),
            'phone_number' => $this->faker->phoneNumber(),
            'date_of_birth' => $this->faker->date(),
            'gender' => Member::GENDER_MALE,
            'status' => Member::STATUS_ACTIVE,
        ];
    }
}
