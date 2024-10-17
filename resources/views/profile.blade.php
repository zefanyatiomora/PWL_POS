<!-- resources/views/profile.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ubah Foto Profil</h2>
    
    <!-- Notifikasi untuk upload sukses atau error -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Menampilkan foto profil yang ada -->
    <div class="mb-3">
        <h4>Foto Profil Saat Ini:</h4>
        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="img-fluid" style="max-width: 200px;">
    </div>

    <!-- Form upload foto profil -->
    <form action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="profile_picture">Pilih Foto Profil:</label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection
