@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Penjualan</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/penjualan/import') }}')" class="btn btn-info">Import Penjualan</button>
            <a href="{{ url('/penjualan/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export Penjualan</a>
            <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export Penjualan</a>
            <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter data -->
        <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm row text-sm mb-0">
                        <label for="filter_date" class="col-md-1 col-form-label">Filter</label>
                        <div class="col-md-3">
                            <select name="filter_kategori" class="form-control form-control-sm filter_kategori">
                                <option value="">- Semua Kategori -</option>
                                @foreach($kategori as $l)
                                    <option value="{{ $l->kategori_id }}">{{ $l->kategori_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori Penjualan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <table class="table table-bordered table-sm table-striped table-hover" id="table-penjualan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Penjualan ID</th>
                    <th>User ID</th>
                    <th>Pembeli</th>
                    <th>Kode Penjualan</th>
                    <th>Tanggal Penjualan</th>
                    <th>Jumlah</th>
                    <th>Jenis Barang</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
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

var tablePenjualan;
$(document).ready(function() {
    tablePenjualan = $('#table-penjualan').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": "{{ url('penjualan/list') }}",
            "dataType": "json",
            "type": "POST",
            "data": function(d) {
                d.filter_kategori = $('.filter_kategori').val();
            }
        },
        columns: [
            {
                data: "No_Urut",
                className: "text-center",
                width: "5%",
                orderable: false,
                searchable: false
            },
            {
                data: "penjualan_id",
                className: "",
                width: "10%",
                orderable: true,
                searchable: true
            },
            {
                data: "user_id",
                className: "",
                width: "10%",
                orderable: true,
                searchable: true
            },
            {
                data: "pembeli",
                className: "",
                width: "20%",
                orderable: true,
                searchable: true
            },
            {
                data: "penjualan_kode",
                className: "",
                width: "15%",
                orderable: true,
                searchable: true
            },
            {
                data: "penjualan_tanggal",
                className: "",
                width: "15%",
                orderable: true,
                searchable: true,
                render: function(data) {
                    return new Intl.DateTimeFormat('id-ID').format(new Date(data));
                }
            },
            {
                data: "jumlah",
                className: "",
                width: "5%",
                orderable: true,
                searchable: false
            },
            {
                data: "jenis_barang",
                className: "",
                width: "10%",
                orderable: true,
                searchable: false
            },
            {
                data: "total_harga",
                className: "",
                width: "10%",
                orderable: true,
                searchable: false,
                render: function(data) {
                    return new Intl.NumberFormat('id-ID').format(data);
                }
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

    $('#table-penjualan_filter input').unbind().bind().on('keyup', function(e) {
        if(e.keyCode == 13) { // enter key
            tablePenjualan.search(this.value).draw();
        }
    });

    $('.filter_kategori').change(function() {
        tablePenjualan.draw();
    });
});
</script>
@endpush
