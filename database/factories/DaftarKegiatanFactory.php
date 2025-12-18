<?php

namespace Database\Factories;

use App\Models\DaftarKegiatan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DaftarKegiatan>
 */
class DaftarKegiatanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nama_kegiatan' => $this->faker->sentence(3),
            'tanggal_kegiatan' => $this->faker->date(),
            'tempat' => $this->faker->address(),
            'waktu_mulai' => $this->faker->time(),
            'waktu_selesai' => $this->faker->time(),
            'status_kegiatan' => 'pending',
        ];
    }
}
