<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        
        for ($i = 1; $i <= 10; $i++) {
            $tanggal = Carbon::now(); // Tanggal hari ini
            
            $data[] = [
                'penjualan_id' => $i,
                'user_id' => '3',
                'pembeli' => 'Pembeli ' . $i,
                'penjualan_kode' => 'PJ' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'penjualan_tanggal' => $tanggal,
            ];
        }
        
        DB::table('t_penjualan')->insert($data);
    }
}
