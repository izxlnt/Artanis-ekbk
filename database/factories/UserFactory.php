<?php

namespace Database\Factories;

use App\Models\PenggunaKilang;
use App\Models\Shuttle;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $pengguna_kilang = PenggunaKilang::factory()->create();
        $hashed_random_password = Hash::make("1234567890");
        $shuttle = Shuttle::findorfail($pengguna_kilang->shuttle_id);

        //KILANG
        // return [
        //             'name' => $shuttle->nama_kilang,
        //             'email' => $shuttle->email,
        //             'password' => $hashed_random_password, // password
        //             'remember_token' => Str::random(10),
        //             'login_id' => $shuttle->no_ssm,
        //             'kategori_pengguna'  => 'IBK',
        //             'is_approved' => '1',
        //             'shuttle_type' => $shuttle->shuttle_type,
        //             'shuttle_id' => $shuttle->id,
        //         ];

        //USER
        return [
            'name' => $pengguna_kilang->name,
            'email' => $pengguna_kilang->email,
            'password' => $hashed_random_password, // password
            'remember_token' => Str::random(10),
            'login_id' => $pengguna_kilang->no_kad_pengenalan,
            'kategori_pengguna'  => 'IBK',
            'is_approved' => '1',
            'pengguna_kilang_id' => $pengguna_kilang->id,
            'shuttle_id' => $pengguna_kilang->shuttle_id,
            'shuttle_type' => $shuttle->shuttle_type,

        ];

    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
