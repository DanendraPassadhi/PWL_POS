<form action="{{ url('/barang/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Barang</h5>
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
                        <option value="{{ $l->id }}">{{ $l->kategori_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-kategori_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kode Barang</label>
                    <input value="" type="text" name="barang_kode" id="barang_kode" class="form-control" required>
                    <small id="error-barang_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input value="" type="text" name="barang_nama" id="barang_nama" class="form-control" required>
                    <small id="error-barang_nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Harga Beli</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" class="form-control" id="display_harga_beli" value="" required oninput="formatNumber(this, 'harga_beli')">
                        <input type="hidden" name="harga_beli" id="harga_beli" value="">
                    </div>
                    <small id="error-harga_beli" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Harga Jual</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" class="form-control" id="display_harga_jual" value="" required oninput="formatNumber(this, 'harga_jual')">
                        <input type="hidden" name="harga_jual" id="harga_jual" value="">
                    </div>
                    <small id="error-harga_jual" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Supplier</label>
                    <select name="supplier_id" id="supplier_id" class="form-control" required>
                        <option value="">- Pilih Supplier -</option>
                        @foreach($supplier as $s)
                        <option value="{{ $s->id }}">{{ $s->supplier_nama }}</option>
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
    $("#form-tambah").validate({
        rules: {
            kategori_id: {
                required: true,
                number: true
            },
            barang_kode: {
                required: true,
                minlength: 3,
                maxlength: 10
            },
            barang_nama: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            harga_beli: {
                required: true,
                number: true
            },
            harga_jual: {
                required: true,
                number: true
            },
            supplier_id: {
                required: true,
                number: true
            }
        },
        submitHandler: function(form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    if(response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        dataBarang.ajax.reload();
                    } else {
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
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
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