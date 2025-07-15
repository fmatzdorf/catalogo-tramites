<?php

namespace Database\Factories;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['admin', 'institutional']),
            'institution_id' => null,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user should be an admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'institution_id' => null,
        ]);
    }

    /**
     * Indicate that the user should be institutional.
     */
    public function institutional(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'institutional',
            'institution_id' => Institution::factory(),
        ]);
    }

    /**
     * Indicate that the user should be institutional with a specific institution.
     */
    public function forInstitution(int $institutionId): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'institutional',
            'institution_id' => $institutionId,
        ]);
    }

}
