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
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan
            </div>
            <a href="{{ url('/stok') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/stok/' . $stok->stok_id.'/update_ajax') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Barang</label>
                    <select name="barang_id" id="barang_id" class="form-control" required>
                        <option value="">- Pilih Barang -</option>
                        @foreach($kategori as $l)
                        <option {{ ($l->barang_id == $stok->barang_id)? 'selected' : '' }} value="{{ $l->barang_id }}">{{ $l->barang_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-barang_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Penginput</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">- Pilih Penginput -</option>
                        @foreach($user as $l)
                        <option {{ ($l->user_id == $stok->user_id)? 'selected' : '' }} value="{{ $l->user_id }}">{{ $l->nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-user_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Stok</label>
                    <input value="{{ $stok->stok_tanggal }}" type="text" name="stok_tanggal" id="stok_tanggal" class="form-control" required>
                    <small id="error-stok_tanggal" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jumlah Stok</label>
                    <input value="{{ $stok->stok_jumlah }}" type="text" name="stok_jumlah" id="stok_jumlah" class="form-control" required>
                    <small id="error-stok_jumlah" class="error-text form-text text-danger"></small>
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
            stok_kode: {required: true, minlength: 3},
            stok_nama: {required: true, maxlength: 100},
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
                        tableStok.ajax.reload();
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