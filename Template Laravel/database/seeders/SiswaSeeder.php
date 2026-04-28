<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $siswaPerKelas = [
            // Paket A Kelas 1 (id_kelas = 1)
            1 => [
                'Agus Setiawan', 'Budi Santoso', 'Citra Lestari', 'Dedi Kurniawan', 'Eka Putri',
                'Fajar Nugroho', 'Gita Rahayu', 'Hendra Wijaya', 'Indah Permata', 'Joko Susilo',
                'Kartini Dewi', 'Lukman Hakim', 'Maya Sari', 'Nanda Pratama', 'Oki Setiawan',
                'Putri Handayani', 'Rizky Maulana', 'Sari Wulandari', 'Tono Prasetyo', 'Umar Bakri',
                'Vina Melati', 'Wahyu Hidayat', 'Xena Safitri', 'Yudi Prasetya', 'Zara Cantika',
                'Abdul Hamid', 'Bella Safira', 'Candra Kusuma', 'Dina Marlina', 'Eko Purnomo',
                'Fitri Anggraini', 'Gilang Ramadhan', 'Hani Pertiwi', 'Ivan Saputra', 'Julia Maharani',
            ],
            2 => [
                'Kevin Pratama', 'Lina Susanti', 'Miko Wijaya', 'Nina Kusuma', 'Omar Faruq',
                'Pita Rahayu', 'Qori Handayani', 'Randi Setiawan', 'Sinta Dewi', 'Taufik Hidayat',
                'Umi Kalsum', 'Victor Santoso', 'Winda Lestari', 'Xander Putra', 'Yanti Marlina',
                'Zahra Amelia', 'Andi Firmansyah', 'Bagas Prasetyo', 'Cici Permata', 'Danu Saputra',
                'Ella Fitriani', 'Fandi Kurniawan', 'Grace Hapsari', 'Hasan Basri', 'Ira Novita',
                'Jaka Tarub', 'Kiki Amalia', 'Leo Prasetya', 'Mia Oktavia', 'Niko Surya',
                'Olive Santika', 'Pandu Wijaya', 'Queen Safira', 'Reza Maulana', 'Salsa Nabila',
            ],
            3 => [
                'Tegar Prakoso', 'Uli Hasanah', 'Vino Nugraha', 'Wulan Sari', 'Yogi Pratama',
                'Zidan Ramadhan', 'Adit Suryana', 'Bela Pertiwi', 'Chandra Putra', 'Dita Anggraini',
                'Erwin Santoso', 'Fika Rahayu', 'Guntur Wibowo', 'Hilda Permata', 'Irfan Hakim',
                'Jeni Kusuma', 'Kris Setiawan', 'Laura Dewi', 'Maulana Yusuf', 'Nisa Amelia',
                'Oscar Pratama', 'Peni Lestari', 'Rama Wijaya', 'Shinta Novita', 'Tito Saputra',
                'Ulin Nuha', 'Viola Sari', 'Wisnu Wardana', 'Yella Fitriani', 'Zaki Mubarak',
                'Arif Budiman', 'Bunga Citra', 'Dimas Prasetyo', 'Erika Santika', 'Farhan Maulana',
            ],
            4 => [
                'Galih Permana', 'Hesti Wulandari', 'Imam Syafii', 'Jihan Nabila', 'Koko Susanto',
                'Laras Setyani', 'Muhamad Rizki', 'Nabila Zahra', 'Oki Firmansyah', 'Pipit Rahayu',
                'Qodri Maulana', 'Rina Marlina', 'Syahrul Ramadhan', 'Tika Pertiwi', 'Ucup Setiawan',
                'Vera Amelia', 'Wahid Saputra', 'Yeni Kusuma', 'Zulfa Anggraini', 'Amir Hamzah',
                'Bintang Pratama', 'Cindy Lestari', 'Doni Wijaya', 'Endah Sari', 'Fauzan Hakim',
                'Gina Novita', 'Hakim Santoso', 'Icha Permata', 'Joni Ramadhan', 'Kiara Dewi',
                'Lutfi Prasetya', 'Mega Wulandari', 'Naufal Maulana', 'Olla Fitriani', 'Pras Suryana',
            ],
            5 => [
                'Rini Susanti', 'Sandi Kurniawan', 'Tiara Amelia', 'Ucok Situmorang', 'Vivi Rahayu',
                'Wawan Setiawan', 'Yola Pertiwi', 'Zulkifli Harahap', 'Aris Budiman', 'Bayu Saputra',
                'Cika Anggraini', 'Derry Pratama', 'Erni Lestari', 'Ferdi Santoso', 'Gita Permata',
                'Hary Wijaya', 'Ines Novita', 'Jefri Maulana', 'Karina Dewi', 'Luki Prasetyo',
                'Merry Wulandari', 'Nando Ramadhan', 'Ocha Fitriani', 'Prita Suryana', 'Romi Santika',
                'Sella Kusuma', 'Tedy Setiawan', 'Ulfa Marlina', 'Valdo Prasetya', 'Wilda Sari',
                'Yanto Firmansyah', 'Zara Novita', 'Alvin Hakim', 'Beby Permata', 'Cory Amelia',
            ],
            6 => [
                'Danu Wijaya', 'Elsa Rahayu', 'Fanny Pertiwi', 'Gery Santoso', 'Hana Kusuma',
                'Ibnu Hajar', 'Joko Purnomo', 'Krisna Bayu', 'Laila Fitriani', 'Manda Suryana',
                'Neno Prasetya', 'Oriza Sativa', 'Piyan Setiawan', 'Qila Amelia', 'Rendra Maulana',
                'Sasa Dewi', 'Teguh Wibowo', 'Ulfah Marlina', 'Vandi Ramadhan', 'Weni Lestari',
                'Yogi Surya', 'Zaenab Hasanah', 'Aldo Pratama', 'Berta Sari', 'Candra Wijaya',
                'Diah Pertiwi', 'Erlan Santoso', 'Fira Novita', 'Ganda Putra', 'Helmi Hakim',
                'Ika Wulandari', 'Jeri Saputra', 'Keni Permata', 'Lian Fitriani', 'Miko Prasetyo',
            ],
            7 => [
                'Niko Ramadhan', 'Ovi Rahayu', 'Pandu Setiawan', 'Qori Amelia', 'Raka Pratama',
                'Sindi Kusuma', 'Tama Wijaya', 'Ully Pertiwi', 'Vero Santoso', 'Weni Suryana',
                'Yuda Prasetya', 'Zaki Firmansyah', 'Agil Maulana', 'Bella Dewi', 'Cahyo Wibowo',
                'Desi Marlina', 'Evan Sari', 'Feny Novita', 'Gani Hakim', 'Hera Permata',
                'Ilham Saputra', 'Julia Fitriani', 'Kiki Lestari', 'Lando Ramadhan', 'Mela Pertiwi',
                'Nuri Santika', 'Okki Setiawan', 'Pasha Amelia', 'Ridho Pratama', 'Siska Rahayu',
                'Tari Kusuma', 'Usman Harahap', 'Vila Wijaya', 'Wito Santoso', 'Yoga Prasetya',
            ],
            8 => [
                'Zeny Amelia', 'Agung Setiawan', 'Baiq Pertiwi', 'Catur Wijaya', 'Dewi Lestari',
                'Elman Santoso', 'Feli Rahayu', 'Ganda Ramadhan', 'Hesti Novita', 'Icang Suryana',
                'Jeki Prasetya', 'Kania Dewi', 'Loris Hakim', 'Mita Permata', 'Nana Saputra',
                'Ojan Firmansyah', 'Popi Marlina', 'Qomar Maulana', 'Robi Setiawan', 'Susi Fitriani',
                'Tono Wibowo', 'Umi Lestari', 'Vega Pertiwi', 'Wino Santika', 'Yola Amelia',
                'Zico Pratama', 'Ambar Kusuma', 'Bondan Wijaya', 'Cinta Rahayu', 'Dodi Ramadhan',
                'Elni Novita', 'Fino Suryana', 'Geby Prasetya', 'Heru Saputra', 'Ika Permata',
            ],
            9 => [
                'Jaka Santoso', 'Kinar Dewi', 'Lodi Hakim', 'Mona Marlina', 'Nabil Maulana',
                'Ocha Setiawan', 'Pita Fitriani', 'Quentin Surya', 'Rosi Wibowo', 'Seno Pratama',
                'Tini Amelia', 'Ucup Firmansyah', 'Vira Kusuma', 'Wandi Wijaya', 'Yeni Rahayu',
                'Zulha Ramadhan', 'Acha Novita', 'Bono Suryana', 'Ciko Prasetyo', 'Dani Saputra',
                'Elok Permata', 'Fandi Santika', 'Gela Pertiwi', 'Hadi Setiawan', 'Ica Fitriani',
                'Jono Lestari', 'Koko Ramadhan', 'Leni Dewi', 'Miko Hakim', 'Nona Marlina',
                'Opik Maulana', 'Pino Santoso', 'Qila Pertiwi', 'Rino Wijaya', 'Sela Amelia',
            ],
        ];

        foreach ($siswaPerKelas as $kelasId => $namaList) {
            foreach ($namaList as $nama) {
                Siswa::create([
                    'nama_siswa'    => $nama,
                    'Kelasid_kelas' => $kelasId,
                ]);
            }
        }
    }
}