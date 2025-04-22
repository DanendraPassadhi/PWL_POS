<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\BarangModel;

class PenjualanController extends Controller
{
    public function index()
    {
        $activeMenu = 'penjualan';
        $breadcrumb = (object) [
            'title' => 'Data Penjualan',
            'list' => ['Home', 'Penjualan']
        ];
        $user = UserModel::select('user_id', 'nama')->get();
        return view('penjualan.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'user'      => $user
        ]);
    }

    public function list(Request $request)
    {
        $penjualan = PenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')
            ->with(['user']);
        $user_id = $request->input('filter_user');
        if (!empty($user_id)) {
            $penjualan->where('user_id', $user_id);
        }
        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('barang', function ($penjualan) {
                $barang = '';
                foreach ($penjualan->penjualan_detail as $detail) {
                    $barang .= $detail->barang->barang_nama . ' (' . $detail->jumlah . ')<br>';
                }
                return $barang;
            })
            ->addColumn('total_transaksi', function ($penjualan) {
                $total = 0;
                foreach ($penjualan->penjualan_detail as $detail) {
                    $total += $detail->harga * $detail->jumlah;
                }
                return 'Rp ' . number_format($total, 0, ',', '.');
            })
            ->addColumn('aksi', function ($penjualan) {
                $btn = '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['barang', 'total_transaksi', 'aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $user = UserModel::select('user_id', 'nama')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama', 'harga_jual')->get();

        return view('penjualan.create_ajax', [
            'user' => $user,
            'detail' => $barang
        ]);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_tanggal' => ['required', 'date'],
                'barang_id' => ['required', 'array', 'min:1'],
                'barang_id.*' => ['required', 'integer', 'exists:m_barang,barang_id'],
                'jumlah' => ['required', 'array', 'min:1'],
                'jumlah.*' => ['required', 'integer', 'min:1'],
                'pembeli' => ['required', 'string', 'min:3', 'max:50']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                DB::beginTransaction();

                $penjualan = PenjualanModel::create([
                    'user_id' => auth()->user()->user_id,
                    'penjualan_tanggal' => $request->penjualan_tanggal,
                    'penjualan_kode' => 'PJ' . date('YmdHis'),
                    'pembeli' => $request->pembeli
                ]);

                // Simpan detail penjualan untuk setiap barang
                foreach ($request->barang_id as $index => $barang_id) {
                    $barang = BarangModel::find($barang_id);
                    if (!$barang) {
                        throw new \Exception("Barang dengan ID {$barang_id} tidak ditemukan");
                    }

                    PenjualanDetailModel::create([
                        'penjualan_id' => $penjualan->penjualan_id,
                        'barang_id' => $barang_id,
                        'jumlah' => $request->jumlah[$index],
                        'harga' => $barang->harga_jual
                    ]);
                }

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }
        return redirect('/');
    }

    public function edit_ajax($id)
    {
        $penjualan = PenjualanModel::with(['penjualan_detail.barang'])->find($id);
        $user = UserModel::select('user_id', 'nama')->get();
        return view('penjualan.edit_ajax', ['penjualan' => $penjualan, 'user' => $user]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_tanggal' => ['required', 'date'],
                'user_id' => ['required', 'integer', 'exists:m_user,id'],
                'pembeli' => ['required', 'min:3', 'max:50'],
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }
            $check = PenjualanModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax($id)
    {
        $penjualan = PenjualanModel::with(['penjualan_detail.barang'])->find($id);
        return view('penjualan.confirm_ajax', ['penjualan' => $penjualan]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $penjualan = PenjualanModel::find($id);
            if ($penjualan) {

                PenjualanDetailModel::where('penjualan_id', $id)->delete();

                $penjualan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function show_ajax(string $id)
    {
        $penjualan = PenjualanModel::with(['penjualan_detail.barang'])->find($id);
        $user = UserModel::all();

        return view('penjualan.show_ajax', [
            'penjualan' => $penjualan,
            'user' => $user
        ]);
    }

    public function import()
    {
        $user = UserModel::select('user_id', 'nama')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama', 'harga_jual')->get();

        return view('penjualan.import', [
            'user' => $user,
            'detail' => $barang
        ]);
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_penjualan' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                DB::beginTransaction();

                $file = $request->file('file_penjualan');
                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray(null, false, true, true);

                if (count($data) > 1) {
                    $currentPenjualan = null;
                    $currentKode = '';

                    foreach ($data as $baris => $value) {
                        if ($baris > 1) {
                            // Cek apakah user_id valid
                            $user = UserModel::find($value['A']);
                            if (!$user) {
                                throw new \Exception("User dengan ID {$value['A']} tidak ditemukan pada baris {$baris}");
                            }

                            // Cek apakah barang_id valid
                            $barang = BarangModel::find($value['D']);
                            if (!$barang) {
                                throw new \Exception("Barang dengan ID {$value['D']} tidak ditemukan pada baris {$baris}");
                            }

                            if ($currentKode !== $value['C'] || !$currentPenjualan) {

                                $currentPenjualan = PenjualanModel::create([
                                    'user_id' => $value['A'],
                                    'pembeli' => $value['B'],
                                    'penjualan_kode' => $value['C'],
                                    'penjualan_tanggal' => now(),
                                    'created_at' => now(),
                                ]);
                                $currentKode = $value['C'];
                            }

                            // Simpan detail penjualan
                            PenjualanDetailModel::create([
                                'penjualan_id' => $currentPenjualan->penjualan_id,
                                'barang_id' => $value['D'],
                                'jumlah' => $value['E'],
                                'harga' => $barang->harga_jual
                            ]);
                        }
                    }
                } else {
                    throw new \Exception("Tidak ada data yang dapat diimport");
                }

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        $penjualan = PenjualanModel::with(['penjualan_detail' => function ($query) {
            $query->orderBy('detail_id', 'asc');
        }, 'penjualan_detail.barang', 'user'])
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Penjualan');
        $sheet->setCellValue('C1', 'Nama Kasir');
        $sheet->setCellValue('D1', 'Nama Pembeli');
        $sheet->setCellValue('E1', 'Tanggal Penjualan');
        $sheet->setCellValue('F1', 'Barang');
        $sheet->setCellValue('G1', 'Jumlah');
        $sheet->setCellValue('H1', 'Harga');
        $sheet->setCellValue('I1', 'Subtotal');

        $sheet->getStyle('A1:I1')->getFont()->setBold(true);

        $row = 2;
        $no = 1;
        foreach ($penjualan as $p) {
            $firstRow = $row;
            $totalTransaksi = 0;
            foreach ($p->penjualan_detail as $detail) {
                $subtotal = $detail->jumlah * $detail->harga;
                $totalTransaksi += $subtotal;

                $sheet->setCellValue('A' . $row, $no);
                $sheet->setCellValue('B' . $row, $p->penjualan_kode);
                $sheet->setCellValue('C' . $row, $p->user->nama);
                $sheet->setCellValue('D' . $row, $p->pembeli);
                $sheet->setCellValue('E' . $row, $p->penjualan_tanggal);
                $sheet->setCellValue('F' . $row, $detail->barang->barang_nama);
                $sheet->setCellValue('G' . $row, $detail->jumlah);
                $sheet->setCellValue('H' . $row, $detail->harga);
                $sheet->setCellValue('I' . $row, $subtotal);
                $row++;
            }

            $sheet->setCellValue('A' . $row, 'Total Transaksi');
            $sheet->setCellValue('I' . $row, $totalTransaksi);
            $sheet->mergeCells('A' . $row . ':H' . $row);
            $sheet->getStyle('A' . $row . ':I' . $row)->getFont()->setBold(true);
            $row++;
            $no++;

            // Merge cells untuk data yang sama
            if ($row > $firstRow) {
                $sheet->mergeCells('A' . $firstRow . ':A' . ($row - 2));
                $sheet->mergeCells('B' . $firstRow . ':B' . ($row - 2));
                $sheet->mergeCells('C' . $firstRow . ':C' . ($row - 2));
                $sheet->mergeCells('D' . $firstRow . ':D' . ($row - 2));
                $sheet->mergeCells('E' . $firstRow . ':E' . ($row - 2));
            }
        }

        // Format angka
        $sheet->getStyle('H2:I' . ($row - 1))->getNumberFormat()->setFormatCode('Rp #,##0');

        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Penjualan');
        $sheet->getStyle('A1:I' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Penjualan ' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $penjualan = PenjualanModel::with(['penjualan_detail' => function ($query) {
            $query->orderBy('detail_id', 'asc');
        }, 'penjualan_detail.barang', 'user'])
            ->get();

        $pdf = Pdf::loadView('penjualan.export_pdf', ['penjualan' => $penjualan]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption('isRemoteEnabled', true); // set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data penjualan ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
