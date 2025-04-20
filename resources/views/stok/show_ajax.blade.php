@empty($stok)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
            <button type="button" data-dismiss="modal" class="btn btn-warning">Tutup</button>
        </div>
    </div>
</div>
@else
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Data Stok</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID</th>
                    <td>{{ $stok->stok_id }}</td>
                </tr>
                <tr>
                    <th>Barang</th>
                    <td>{{ $stok->barang->barang_nama }}</td>
                </tr>
                <tr>
                    <th>Penginput</th>
                    <td>{{ $stok->user->user_nama }}</td>
                </tr>
                <tr>
                    <th>Tanggal stok</th>
                    <td>{{ $stok->stok_tanggal }}</td>
                </tr>
                <tr>
                    <th>Jumlah stok</th>
                    <td>{{ $stok->stok_jumlah }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Tutup</button>
        </div>
    </div>
</div>
@endempty