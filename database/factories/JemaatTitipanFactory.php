<?php

namespace Database\Factories;

use App\Models\JemaatTitipan;
use App\Models\Wilayah;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use App\Models\Pendidikan;
use App\Models\BidangIlmu;
use App\Models\Pekerjaan;
use Illuminate\Database\Eloquent\Factories\Factory;

class JemaatTitipanFactory extends Factory
{
    protected $model = JemaatTitipan::class;

    public function definition()
    {
        return [
            'id_wilayah' => Wilayah::inRandomOrder()->first()->id_wilayah,
            'nama_jemaat' => $this->faker->name,
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date,
            'agama' => $this->faker->randomElement(['Kristen']),
            'kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'alamat_jemaat' => $this->faker->address,
            'alamat_domisili' => $this->faker->address,
            'id_kelurahan' => Kelurahan::inRandomOrder()->first()->id_kelurahan,
            'id_kecamatan' => Kecamatan::inRandomOrder()->first()->id_kecamatan,
            'id_kabupaten' => Kabupaten::inRandomOrder()->first()->id_kabupaten,
            'id_provinsi' => Provinsi::inRandomOrder()->first()->id_provinsi,
            'kodepos' => $this->faker->postcode,
            'telepon' => $this->faker->phoneNumber,
            'hp' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'nik' => $this->faker->unique()->numerify('NIK########'),
            'no_kk' => $this->faker->numerify('KK##########'),
            'nama_ortu' => $this->faker->name,
            'telepon_ortu' => $this->faker->phoneNumber,
            'photo' => $this->faker->imageUrl(640, 480, 'people'),
            'tanggal_baptis' => $this->faker->date,
            'golongan_darah' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'id_pendidikan' => Pendidikan::inRandomOrder()->first()->id_pendidikan,
            'id_ilmu' => BidangIlmu::inRandomOrder()->first()->id_ilmu,
            'id_pekerjaan' => Pekerjaan::inRandomOrder()->first()->id_pekerjaan,
            'instansi' => $this->faker->company,
            'penghasilan' => $this->faker->numberBetween(1000000, 20000000),
            'gereja_ibadah' => $this->faker->word,
            'alat_transportasi' => $this->faker->word,
            'nomorsurat' => $this->faker->word,
            'surat' => $this->faker->word,
        ];
    }
}

