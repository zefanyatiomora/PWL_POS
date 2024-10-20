@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Detail Penjualan</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($penjualan)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data penjualan tidak ditemukan.
        </div>
        @else
        <table class="table table-bordered table-striped table-hover table-sm">
            <tr>
                <th>ID Penjualan</th>
                <td>{{ $penjualan->penjualan_id }}</td>
            </tr>
            <tr>
                <th>User ID</th>
                <td>{{ $penjualan->user_id }}</td> <!-- Assuming user_id is directly accessible -->
            </tr>
            <tr>
                <th>Pembeli</th>
                <td>{{ $penjualan->pembeli }}</td>
            </tr>
            <tr>
                <th>Kode Penjualan</th>
                <td>{{ $penjualan->penjualan_kode }}</td>
            </tr>
            <tr>
                <th>Tanggal Penjualan</th>
                <td>{{ \Carbon\Carbon::parse($penjualan->penjualan_tanggal)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Detail Penjualan</th>
                <td>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Jenis Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan->details as $detail)
                            <tr>
                                <td>{{ $detail->barang->jenis_barang }}</td> <!-- Adjust according to your model -->
                                <td>{{ $detail->jumlah }}</td>
                                <td>{{ number_format($detail->harga_jual, 2, ',', '.') }}</td> <!-- Adjust field name if necessary -->
                                <td>{{ number_format($detail->total_harga, 2, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <th>Total Keseluruhan</th>
                <td>{{ number_format($penjualan->details->sum('total_harga'), 2, ',', '.') }}</td>
            </tr>
        </table>
        @endempty
        <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
