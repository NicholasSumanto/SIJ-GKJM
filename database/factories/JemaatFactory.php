<?php

namespace Database\Factories;

use App\Models\Jemaat;
use App\Models\Wilayah;
use App\Models\Status;
use App\Models\Pernikahan;
use App\Models\BaptisSidi;
use App\Models\BaptisAnak;
use App\Models\BaptisDewasa;
use App\Models\Pendidikan;
use App\Models\BidangIlmu;
use App\Models\Pekerjaan;
use App\Models\Provinsi;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
use App\Models\kabupaten;
use Illuminate\Database\Eloquent\Factories\Factory;

class JemaatFactory extends Factory
{
    protected $model = Jemaat::class;

    public function definition()
    {
        return [
            'id_wilayah' => Wilayah::inRandomOrder()->first()->id_wilayah,
            'id_status' => Status::inRandomOrder()->first()->id_status,
            'stamboek' => $this->faker->unique()->numerify('STB###'),
            'nama_jemaat' => $this->faker->name(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'alamat_jemaat' => $this->faker->address(),
            'kodepos' => $this->faker->postcode(),
            'telepon' => $this->faker->phoneNumber(),
            'hp' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'nik' => $this->faker->unique()->numerify('NIK########'),
            'no_kk' => $this->faker->unique()->numerify('KK########'),
            'photo' => $this->faker->imageUrl(640, 480, 'people'),
            'tanggal_baptis' => $this->faker->date(),
            'golongan_darah' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'ilmu' => $this->faker->jobTitle,
            'pekerjaan' => $this->faker->jobTitle,
            'instansi' => $this->faker->company(),
            'penghasilan' => $this->faker->numberBetween(1000000, 20000000),
            'gereja_baptis' => $this->faker->company(),
            'alat_transportasi' => $this->faker->randomElement(['Mobil', 'Motor', 'Sepeda']),
        ];
    }
}

