@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($barang)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
            <a href="{{ url('barang') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
            <form method="POST" action="{{ url('/barang/'.$barang->barang_id) }}" class="form-horizontal">
                @csrf
                {!! method_field('PUT') !!}
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Kategori</label>
                    <div class="col-11">
                        <select class="form-control" id="kategori_id" name="kategori_id" required>
                            <option value="">- Pilih Kategori -</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item->id }}" @if($item->id == $barang->kategori_id) selected @endif>{{ $item->kategori_nama }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Kode Barang</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="barang_kode" name="barang_kode" value="{{ old('barang_kode', $barang->barang_kode) }}" required>
                        @error('barang_kode')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Nama Barang</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="barang_nama" name="barang_nama" value="{{ old('barang_nama', $barang->barang_nama) }}" required>
                        @error('barang_nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Harga Beli</label>
                    <div class="col-11">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" class="form-control" id="display_harga_beli" value="{{ old('harga_beli', number_format($barang->harga_beli, 0, ',', ' ')) }}" required oninput="formatNumber(this, 'harga_beli')">
                            <input type="hidden" name="harga_beli" id="harga_beli" value="{{ old('harga_beli', $barang->harga_beli) }}">
                        </div>
                        @error('harga_beli')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Harga Jual</label>
                    <div class="col-11">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" class="form-control" id="display_harga_jual" value="{{ old('harga_jual', number_format($barang->harga_jual, 0, ',', ' ')) }}" required oninput="formatNumber(this, 'harga_jual')">
                            <input type="hidden" name="harga_jual" id="harga_jual" value="{{ old('harga_jual', $barang->harga_jual) }}">
                        </div>
                        @error('harga_jual')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Supplier</label>
                    <div class="col-11">
                        <select class="form-control" id="supplier_id" name="supplier_id" required>
                            <option value="">- Pilih Supplier -</option>
                            @foreach($supplier as $item)
                                <option value="{{ $item->id }}" @if($item->id == $barang->supplier_id) selected @endif>{{ $item->supplier_nama }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('barang') }}">Kembali</a>
                    </div>
                </div>
            </form>
        @endempty
    </div>
</div>
@endsection

<script>
    function formatNumber(input, hiddenInputId) {
        // Hapus semua karakter non-digit
        let value = input.value.replace(/\D/g, '');
        
        // Simpan nilai integer asli ke hidden input
        document.getElementById(hiddenInputId).value = value;
        
        // Format angka dengan spasi setiap 3 digit dari kanan untuk tampilan
        input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    }
</script>

@push('css')
@endpush
@push('js')
@endpush