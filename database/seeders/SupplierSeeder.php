<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'supplier_nama' => 'PT Elektronik Jaya',
                'supplier_alamat' => 'Jl. Elektronik No. 123, Jakarta',
                'supplier_telp' => '08123456789',
            ],
            [
                'id' => 2,
                'supplier_nama' => 'CV Fashion Indonesia',
                'supplier_alamat' => 'Jl. Mode No. 45, Bandung',
                'supplier_telp' => '08789456123',
            ],
            [
                'id' => 3,
                'supplier_nama' => 'PT Konsumsi Sehat',
                'supplier_alamat' => 'Jl. Makanan No. 67, Surabaya',
                'supplier_telp' => '08567891234',
            ],
        ];
        
        DB::table('m_supplier')->insert($data);
    }
}
