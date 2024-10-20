@extends('layouts.template')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Stok Barang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('stok.index') }}">Stok Barang</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Form Edit Stok</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('stok.update', $stok->stock_id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="barang_id">Barang</label>
                            <select name="barang_id" class="form-control @error('barang_id') is-invalid @enderror">
                                <option value="">Pilih Barang</option>
                                @foreach($barang as $b)
                                    <option value="{{ $b->barang_id }}" {{ $b->barang_id == $stok->barang_id ? 'selected' : '' }}>
                                        {{ $b->barang_nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="supplier_id">Supplier</label>
                            <select name="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                                <option value="">Pilih Supplier</option>
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->supplier_id }}" {{ $s->supplier_id == $stok->supplier_id ? 'selected' : '' }}>
                                        {{ $s->supplier_nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="user_id">User</label>
                            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                                <option value="">Pilih User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $stok->user_id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stok_tanggal">Tanggal Stok</label>
                            <input type="date" name="stok_tanggal" class="form-control @error('stok_tanggal') is-invalid @enderror" value="{{ $stok->stok_tanggal }}">
                            @error('stok_tanggal')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stok_jumlah">Jumlah Stok</label>
                            <input type="number" name="stok_jumlah" class="form-control @error('stok_jumlah') is-invalid @enderror" value="{{ $stok->stok_jumlah }}">
                            @error('stok_jumlah')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('stok.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
