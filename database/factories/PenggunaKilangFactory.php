<?php

namespace Database\Factories;

use App\Models\Shuttle;
use App\Models\PenggunaKilang;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenggunaKilangFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PenggunaKilang::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $warganegara = $this->faker->randomElement(['Bumiputera', 'Bukan Bumiputera', 'Bukan Warganegara']);

        if( $warganegara == "Bukan Warganegara" ){
            $kaum = "Lain-lain";
        }elseif($warganegara == "Bukan Bumiputera"){
            $kaum = $this->faker->randomElement(['Cina', 'India']);
        }else{
            $kaum = "Melayu";
        }
        $shuttle = Shuttle::factory()->create();
        return [
            'name' => $this->faker->name(),
            'jantina' => $this->faker->randomElement(['Lelaki', 'Perempuan']),
            'warganegara' => $warganegara,
            'kaum' => $kaum,
            'email' => $this->faker->unique()->safeEmail(),
            'no_kad_pengenalan' => $this->faker->unique()->numerify('############'),
            'jawatan' => $this->faker->randomElement(['Majikan', 'Pekerja']),
            'no_pekerja' =>  $this->faker->unique()->numerify('#####'),
            'shuttle_type' => $this->faker->randomElement(['3', '4', '5']),
            'shuttle_id' => $shuttle->id,
            // 'shuttle_id' => Shuttle::factory()->create()->id,

        ];
    }
}
