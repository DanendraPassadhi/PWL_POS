<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Pembeli</label>
                    <input type="text" name="pembeli" id="pembeli" class="form-control"
                        placeholder="Masukkan nama pembeli" required>
                    <small id="error-pembeli" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Barang dan Jumlah</label>
                    <div id="barang-container">
                        <div class="input-group mb-2">
                            <select name="barang_id[]" class="form-control barang-select" required>
                                <option value="">- Pilih Barang -</option>
                                @foreach ($detail as $s)
                                    <option value="{{ $s->barang_id }}" data-harga="{{ $s->harga_jual }}">
                                        {{ $s->barang_nama }} - Rp {{ number_format($s->harga_jual, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" name="jumlah[]" class="form-control ml-2" placeholder="Jumlah"
                                required min="1">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-success" onclick="addBarangField()">+</button>
                            </div>
                        </div>
                    </div>
                    <small id="error-barang_id" class="error-text form-text text-danger"></small>
                </div>

                <script>
                    function addBarangField() {
                        var barangContainer = document.getElementById('barang-container');
                        var newField = document.createElement('div');
                        newField.className = 'input-group mb-2';
                        newField.innerHTML = `
                            <select name="barang_id[]" class="form-control barang-select" required>
                                <option value="">- Pilih Barang -</option>
                                @foreach ($detail as $s)
                                <option value="{{ $s->barang_id }}" data-harga="{{ $s->harga_jual }}">{{ $s->barang_nama }} - Rp {{ number_format($s->harga_jual, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                            <input type="number" name="jumlah[]" class="form-control ml-2" placeholder="Jumlah" required min="1">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger" onclick="removeBarangField(this)">-</button>
                            </div>
                        `;
                        barangContainer.appendChild(newField);
                    }

                    function removeBarangField(button) {
                        button.parentElement.parentElement.remove();
                    }
                </script>
                <div class="form-group">
                    <label>Tanggal Penjualan</label>
                    <input value="{{ date('Y-m-d\TH:i:s') }}" type="datetime-local" name="penjualan_tanggal"
                        id="penjualan_tanggal" class="form-control" required>
                    <small id="error-penjualan_tanggal" class="error-text form-text text-danger"></small>
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
                pembeli: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                'barang_id[]': {
                    required: true,
                    digits: true
                },
                'jumlah[]': {
                    required: true,
                    digits: true,
                    min: 1
                },
                penjualan_tanggal: {
                    required: true,
                    date: true
                }
            },
            messages: {
                pembeli: {
                    required: "Silakan masukkan nama pembeli",
                    minlength: "Nama pembeli minimal 3 karakter",
                    maxlength: "Nama pembeli maksimal 50 karakter"
                },
                'barang_id[]': {
                    required: "Silakan pilih minimal satu barang",
                    digits: "ID barang harus berupa angka"
                },
                'jumlah[]': {
                    required: "Silakan masukkan jumlah barang",
                    digits: "Jumlah harus berupa angka",
                    min: "Jumlah minimal 1"
                },
                penjualan_tanggal: {
                    required: "Silakan pilih tanggal penjualan",
                    date: "Format tanggal tidak valid"
                }
            },
            submitHandler: function(form) {
                // Validasi minimal satu barang terpilih
                if ($('select[name="barang_id[]"]').filter(function() {
                        return $(this).val() !== '';
                    }).length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Silakan pilih minimal satu barang'
                    });
                    return false;
                }

                // Validasi jumlah untuk setiap barang
                let isValid = true;
                $('input[name="jumlah[]"]').each(function() {
                    if ($(this).val() === '' || parseInt($(this).val()) < 1) {
                        isValid = false;
                        return false;
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Silakan masukkan jumlah yang valid untuk setiap barang'
                    });
                    return false;
                }

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            tablePenjualan.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menyimpan data'
                        });
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
