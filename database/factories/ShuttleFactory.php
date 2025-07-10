<?php

namespace Database\Factories;

use App\Models\Shuttle;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShuttleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shuttle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $first = "Kilang ";

        $last = $this->faker->numerify('####-####-####');

        $nama_kilang = $first . $last;

        $address = $this->faker->address;

        $poskod = rand(1000, 98859);

        $logitud = rand(1.5345435, 9.4342343);

        $latitud = rand(1.5345435, 9.4342343);

        $ssm_code = $this->faker->randomElement(['A-', 'B-', 'C-']);

        $ssm_no = $this->faker->numerify('######');

        $ssm = $ssm_code . $ssm_no;

        $date = date('Y-m-d H:i:s');

        $nilai_harta = rand(50000.01, 9999999.99);

        $status_hak_milik = $this->faker->randomElement(['Warganegara Malaysia', 'Bukan Warganegara Malaysia']);

        if ($status_hak_milik == "Warganegara Malaysia") {
            $status_warganegara = $this->faker->randomElement(['Bumiputera', 'Bukan Bumiputera']);
        } else {
            $status_warganegara = "Bukan Warganegara";
        }
        return [
            'shuttle_type' => $this->faker->randomElement(['3', '4', '5']),
            'tahun' => '2021',
            'nama_kilang' => $nama_kilang,
            'alamat_kilang_1' => $address,
            'alamat_kilang_poskod' => $poskod,
            'alamat_surat_menyurat_1' => $address,
            'alamat_surat_menyurat_poskod' => $poskod,
            'longtitude_x' => $logitud,
            'langtitude_y' => $latitud,
            'no_telefon' => $this->faker->numerify('##########'),
            'no_faks' => $this->faker->numerify('##########'),
            'no_ssm' => $ssm,
            'tarikh_tubuh' => $date,
            'tarikh_operasi' => $date,
            'taraf_syarikat_catatan' => $this->faker->randomElement(['Hak Milik Perseorangan', 'Perkongsian', 'Syarikat Sendirian Berhad', 'Syarikat Awam Berhad', 'Lain-lain']),
            'nilai_harta' => $nilai_harta,
            'negeri_id' => $this->faker->randomElement(['Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan', 'Pahang', 'Perak']),
            'daerah_id' => $this->faker->randomElement(['Kuantan', 'Machang', 'Besut', 'Hulu Langat', 'Padang Terap', 'Teluk Intan', 'Muar']),
            'email' => $this->faker->unique()->safeEmail,
            'website' => 'www.dummy.web.my',
            'no_lesen' => $ssm,
            'status_hak_milik' => $status_hak_milik,
            'status_warganegara' => $status_warganegara,

        ];
    }
}
