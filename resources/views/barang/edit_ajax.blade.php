@empty($barang)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan
            </div>
            <a href="{{ url('/barang') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/barang/' . $barang->barang_id.'/update_ajax') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kategori Barang</label>
                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                        <option value="">- Pilih Kategori -</option>
                        @foreach($kategori as $l)
                        <option {{ ($l->id == $barang->kategori_id)? 'selected' : '' }} value="{{ $l->id }}">{{ $l->kategori_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-kategori_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kode Barang</label>
                    <input value="{{ $barang->barang_kode }}" type="text" name="barang_kode" id="barang_kode" class="form-control" required>
                    <small id="error-barang_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input value="{{ $barang->barang_nama }}" type="text" name="barang_nama" id="barang_nama" class="form-control" required>
                    <small id="error-barang_nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Harga Beli</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" class="form-control" id="display_harga_beli" value="{{ number_format($barang->harga_beli, 0, ',', ' ') }}" required oninput="formatNumber(this, 'harga_beli')">
                        <input type="hidden" name="harga_beli" id="harga_beli" value="{{ $barang->harga_beli }}">
                    </div>
                    <small id="error-harga_beli" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Harga Jual</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" class="form-control" id="display_harga_jual" value="{{ number_format($barang->harga_jual, 0, ',', ' ') }}" required oninput="formatNumber(this, 'harga_jual')">
                        <input type="hidden" name="harga_jual" id="harga_jual" value="{{ $barang->harga_jual }}">
                    </div>
                    <small id="error-harga_jual" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Supplier</label>
                    <select name="supplier_id" id="supplier_id" class="form-control" required>
                        <option value="">- Pilih Supplier -</option>
                        @foreach($supplier as $l)
                        <option {{ ($l->id == $barang->supplier_id)? 'selected' : '' }} value="{{ $l->id }}">{{ $l->supplier_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-supplier_id" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
<script>
$(document).ready(function() {
    $("#form-edit").validate({
        rules: {
            kategori_id: {required: true},
            barang_kode: {required: true, minlength: 3},
            barang_nama: {required: true, maxlength: 100},
            harga_beli: {required: true, number: true},
            harga_jual: {required: true, number: true},
            supplier_id: {required: true}
        },
        submitHandler: function(form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    if(response.status){
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        dataBarang.ajax.reload();
                    }else{
                        $('.error-text').text('');
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-'+prefix).text(val[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan', 
                            text: response.message
                        });
                    }
                }
            });
            return false;
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});

function formatNumber(input, hiddenInputId) {
    // Hapus semua karakter non-digit
    let value = input.value.replace(/\D/g, '');
    
    // Simpan nilai integer asli ke hidden input
    document.getElementById(hiddenInputId).value = value;
    
    // Format angka dengan spasi setiap 3 digit dari kanan untuk tampilan
    input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
}
</script>
@endempty