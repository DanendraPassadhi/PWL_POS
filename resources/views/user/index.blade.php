@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar User</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/user/import') }}')" class="btn btn-info">Import User</button>
            <a href="{{ url('/user/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export User</a>
            <a href="{{ url('/user/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export User</a>
            <button onclick="modalAction('{{ url('/user/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Filter:</label>
                    <div class="col-3">
                        <select class="form-control" id="level_id" name="level_id" required>
                            <option value="">- Semua -</option>
                            @foreach($level as $item)
                                <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Level User</small>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Level Pengguna</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var dataUser;
    $(document).ready(function() {
        dataUser = $('#table_user').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('user/list') }}",
                dataType: "json",
                type: "POST",
                data: function(d) {
                    d.level_id = $('#level_id').val();
                }
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "username",
                    className: "",
                    width: "20%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "nama",
                    className: "",
                    width: "25%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "level.level_nama",
                    className: "",
                    width: "20%",
                    orderable: true,
                    searchable: false
                },
                {
                    data: "aksi",
                    className: "text-center",
                    width: "10%",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#level_id').on('change', function() {
            dataUser.ajax.reload();
        });
    });
</script>
@endpush