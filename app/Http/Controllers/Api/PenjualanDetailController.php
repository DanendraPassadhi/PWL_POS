<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenjualanDetailModel;
use Illuminate\Support\Facades\Validator;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        $penjualanDetails = PenjualanDetailModel::with(['penjualan', 'barang'])->get();
        return response()->json($penjualanDetails);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penjualan_id' => 'required|exists:t_penjualan,penjualan_id',
            'barang_id' => 'required|exists:m_barang,barang_id',
            'harga' => 'required|numeric',
            'jumlah' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $penjualanDetail = PenjualanDetailModel::create($request->all());

        return response()->json($penjualanDetail->load(['penjualan', 'barang']), 201);
    }

    public function show($id)
    {
        $penjualanDetail = PenjualanDetailModel::with(['penjualan', 'barang'])->findOrFail($id);
        return response()->json($penjualanDetail);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'penjualan_id' => 'sometimes|required|exists:t_penjualan,penjualan_id',
            'barang_id' => 'sometimes|required|exists:m_barang,barang_id',
            'harga' => 'sometimes|required|numeric',
            'jumlah' => 'sometimes|required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $penjualanDetail = PenjualanDetailModel::findOrFail($id);
        $penjualanDetail->update($request->all());

        return response()->json($penjualanDetail->load(['penjualan', 'barang']), 200);
    }

    public function destroy($id)
    {
        $penjualanDetail = PenjualanDetailModel::findOrFail($id);
        $penjualanDetail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data detail penjualan berhasil dihapus',
        ]);
    }
}
