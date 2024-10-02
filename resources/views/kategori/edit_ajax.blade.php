@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    
    <div class="card-body">
        @empty($kategori)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        <a href="{{ url('kategori') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
        <form method="POST" action="{{ url('/kategori/'.$kategori->kategori_id) }}" class="form-horizontal">
            @csrf
            {!! method_field('PUT') !!} <!-- tambahkan baris ini untuk proses edit yang butuh method PUT -->

            <div class="form-group row">
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Kode Kategori</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="kategori_kode" name="kategori_kode" 
                               value="{{ old('kategori_kode', $kategori->kategori_kode) }}" required>
                        @error('kategori_kode')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <label class="col-1 control-label col-form-label">Kategori</label>
                <div class="col-11">
                    <select class="form-control" id="kategori_id" name="kategori_id" required>
                        <option value="">- Pilih Kategori -</option>
                        @foreach($kategori as $item)
                            <option value="{{ $item->kategori_id }}" 
                                @if($item->kategori_id == $kategori->kategori_id) selected @endif>
                                {{ $item->kategori_nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label"></label>
                <div class="col-11">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('kategori') }}">Kembali</a>
                </div>
            </div>
        </form>
        @endempty
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
