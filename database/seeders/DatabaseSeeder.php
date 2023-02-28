<?php

namespace Database\Seeders;

use App\Models\MasterHewan;
use App\Models\ProfileMasjid;
use App\Models\Saldo;
use App\Models\User;
use App\Models\ZiswafVisiMisi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'TempatLahir' => 'Bandung',
            'TanggalLahir' => '1998-12-13',
            'alamat' => 'Bandung',
            'kontak' => '082262366949',
            'JenisKelamin' => 'Laki-laki',
            'role' => 1,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'picture' => 'default_picture.png',
        ]);

        Saldo::create([
            'jumlah_saldo' => 0
        ]);

        MasterHewan::create([
            'nama' => 'Sapi'
        ]);

        MasterHewan::create([
            'nama' => 'Kambing'
        ]);

        ZiswafVisiMisi::create([
            'visi_misi' => 'Visi Misi Ziswaf'
        ]);

        ProfileMasjid::create([
            'visi_misi' => 'Visi Misi Masjid',
            'sejarah' => 'Sejarah Masjid'
        ]);
    }
}
