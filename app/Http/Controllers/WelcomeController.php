<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list'  => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';

        // Ambil data penjualan harian
        $penjualan = PenjualanModel::select(
            DB::raw('DATE(penjualan_tanggal) as tanggal'),
            DB::raw('SUM(t_penjualan_detail.jumlah * t_penjualan_detail.harga) as total')
        )
            ->join('t_penjualan_detail', 't_penjualan.penjualan_id', '=', 't_penjualan_detail.penjualan_id')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $labels = $penjualan->pluck('tanggal');
        $data = $penjualan->pluck('total');

        // Ambil data penjualan per kategori
        $kategori = KategoriModel::select(
            'm_kategori.kategori_id',
            'm_kategori.kategori_nama',
            DB::raw('COALESCE(SUM(t_penjualan_detail.jumlah * t_penjualan_detail.harga), 0) as total')
        )
            ->leftJoin('m_barang', 'm_kategori.kategori_id', '=', 'm_barang.kategori_id')
            ->leftJoin('t_penjualan_detail', 'm_barang.barang_id', '=', 't_penjualan_detail.barang_id')
            ->groupBy('m_kategori.kategori_id', 'm_kategori.kategori_nama')
            ->get();

        $kategoriLabels = $kategori->pluck('kategori_nama');
        $kategoriData = $kategori->pluck('total');

        return view('welcome', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'labels' => $labels,
            'data' => $data,
            'kategoriLabels' => $kategoriLabels,
            'kategoriData' => $kategoriData
        ]);
    }
}
