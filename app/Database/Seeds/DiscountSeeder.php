<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiscountSeeder extends Seeder
{
    public function run()
    {
        // membuat data diskon >= 10 data dengan tanggal unik
        $data = [
            [
                'tanggal' => '2026-07-09',
                'nominal' => 50000,
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'tanggal' => '2026-07-10',
                'nominal' => 75000,
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'tanggal' => '2026-07-11',
                'nominal' => 100000,
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'tanggal' => '2026-07-12',
                'nominal' => 25000,
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'tanggal' => '2026-07-13',
                'nominal' => 150000,
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'tanggal' => '2026-07-14',
                'nominal' => 200000,
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'tanggal' => '2026-07-15',
                'nominal' => 30000,
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'tanggal' => '2026-07-16',
                'nominal' => 80000,
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'tanggal' => '2026-07-17',
                'nominal' => 120000,
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'tanggal' => '2026-07-18',
                'nominal' => 60000,
                'created_at' => date("Y-m-d H:i:s"),
            ],
        ];

        foreach ($data as $item) {
            // insert semua data ke tabel
            $this->db->table('discount')->insert($item);
        }
    }
}
