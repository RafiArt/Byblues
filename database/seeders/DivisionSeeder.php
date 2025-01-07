<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            ['code' => 'DIV001', 'name_divisions' => 'Sekretaris Perusahaan'],
            ['code' => 'DIV002', 'name_divisions' => 'Satuan Pengawas Intern'],
            ['code' => 'DIV018', 'name_divisions' => 'Teknologi Informasi dan Komunikasi'],
            ['code' => 'DIV013', 'name_divisions' => 'Teknologi Informasi (SO-23)'],
            ['code' => 'DIV003', 'name_divisions' => 'Hukum'],
            ['code' => 'DIV014', 'name_divisions' => 'Pengawasan Operasional dan HSE (SO-23)'],
            ['code' => 'DIV019', 'name_divisions' => 'Pengawasan Operasional dan Kesehatan, Keselamatan dan Lingkungan'],
            ['code' => 'DIV015', 'name_divisions' => 'Keuangan, Akuntansi dan Manajemen Risiko'],
            ['code' => 'DIV005', 'name_divisions' => 'Sumber Daya Manusia'],
            ['code' => 'DIV004', 'name_divisions' => 'Umum dan Pengadaan'],
            ['code' => 'DIV007', 'name_divisions' => 'Pemasaran'],
            ['code' => 'DIV008', 'name_divisions' => 'Pengembangan'],
            ['code' => 'DIV020', 'name_divisions' => 'Manajemen Kawasan SIER'],
            ['code' => 'DIV016', 'name_divisions' => 'Kawasan SIER (SO-23)'],
            ['code' => 'DIV017', 'name_divisions' => 'Kawasan PIER (SO-23)'],
            ['code' => 'DIV021', 'name_divisions' => 'Vendor'],
            ['code' => 'DIV022', 'name_divisions' => 'Guest'],
        ];

        foreach ($divisions as $division) {
            DB::table('divisions')->insert([
                'code' => $division['code'],
                'name_divisions' => $division['name_divisions'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}
