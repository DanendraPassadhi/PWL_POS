<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        
        // Supplier 1: PT Elektronik Jaya (5 barang)
        $data[] = [
            'barang_id' => 1,
            'kategori_id' => 6,
            'supplier_id' => 1,
            'barang_kode' => 'E001',
            'barang_nama' => 'Laptop Acer',
            'harga_beli' => 8000000,
            'harga_jual' => 9500000,
        ];
        
        $data[] = [
            'barang_id' => 2,
            'kategori_id' => 6,
            'supplier_id' => 1,
            'barang_kode' => 'E002',
            'barang_nama' => 'Smartphone Samsung',
            'harga_beli' => 3000000,
            'harga_jual' => 3800000,
        ];
        
        $data[] = [
            'barang_id' => 3,
            'kategori_id' => 6,
            'supplier_id' => 1,
            'barang_kode' => 'E003',
            'barang_nama' => 'Smart TV LG',
            'harga_beli' => 5000000,
            'harga_jual' => 6200000,
        ];
        
        $data[] = [
            'barang_id' => 4,
            'kategori_id' => 6,
            'supplier_id' => 1,
            'barang_kode' => 'E004',
            'barang_nama' => 'Printer Epson',
            'harga_beli' => 1500000,
            'harga_jual' => 1800000,
        ];
        
        $data[] = [
            'barang_id' => 5,
            'kategori_id' => 6,
            'supplier_id' => 1,
            'barang_kode' => 'E005',
            'barang_nama' => 'Speaker Bluetooth',
            'harga_beli' => 500000,
            'harga_jual' => 650000,
        ];
        
        // Supplier 2: CV Fashion Indonesia (5 barang)
        $data[] = [
            'barang_id' => 6,
            'kategori_id' => 7,
            'supplier_id' => 2,
            'barang_kode' => 'P001',
            'barang_nama' => 'Kemeja Pria',
            'harga_beli' => 150000,
            'harga_jual' => 225000,
        ];
        
        $data[] = [
            'barang_id' => 7,
            'kategori_id' => 7,
            'supplier_id' => 2,
            'barang_kode' => 'P002',
            'barang_nama' => 'Celana Jeans',
            'harga_beli' => 200000,
            'harga_jual' => 300000,
        ];
        
        $data[] = [
            'barang_id' => 8,
            'kategori_id' => 7,
            'supplier_id' => 2,
            'barang_kode' => 'P003',
            'barang_nama' => 'Jaket Hoodie',
            'harga_beli' => 250000,
            'harga_jual' => 375000,
        ];
        
        $data[] = [
            'barang_id' => 9,
            'kategori_id' => 7,
            'supplier_id' => 2,
            'barang_kode' => 'P004',
            'barang_nama' => 'Kaos Polos',
            'harga_beli' => 80000,
            'harga_jual' => 120000,
        ];
        
        $data[] = [
            'barang_id' => 10,
            'kategori_id' => 7,
            'supplier_id' => 2,
            'barang_kode' => 'P005',
            'barang_nama' => 'Topi Baseball',
            'harga_beli' => 50000,
            'harga_jual' => 75000,
        ];
        
        // Supplier 3: PT Konsumsi Sehat (5 barang)
        $data[] = [
            'barang_id' => 11,
            'kategori_id' => 8,
            'supplier_id' => 3,
            'barang_kode' => 'M001',
            'barang_nama' => 'Mie Instan',
            'harga_beli' => 2500,
            'harga_jual' => 3500,
        ];
        
        $data[] = [
            'barang_id' => 12,
            'kategori_id' => 8,
            'supplier_id' => 3,
            'barang_kode' => 'M002',
            'barang_nama' => 'Biskuit',
            'harga_beli' => 5000,
            'harga_jual' => 7000,
        ];
        
        $data[] = [
            'barang_id' => 13,
            'kategori_id' => 9,
            'supplier_id' => 3,
            'barang_kode' => 'M003',
            'barang_nama' => 'Air Mineral',
            'harga_beli' => 3000,
            'harga_jual' => 4000,
        ];
        
        $data[] = [
            'barang_id' => 14,
            'kategori_id' => 9,
            'supplier_id' => 3,
            'barang_kode' => 'M004',
            'barang_nama' => 'Teh Botol',
            'harga_beli' => 4000,
            'harga_jual' => 5500,
        ];
        
        $data[] = [
            'barang_id' => 15,
            'kategori_id' => 10,
            'supplier_id' => 3,
            'barang_kode' => 'M005',
            'barang_nama' => 'Piring Plastik',
            'harga_beli' => 15000,
            'harga_jual' => 22000,
        ];
        
        DB::table('m_barang')->insert($data);
    }
}
