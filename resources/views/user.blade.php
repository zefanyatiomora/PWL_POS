<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>
    <h1>Data User</h1>
    <a href="/user/tambah">+ Tambah User</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID Level Pengguna</th>
            <th>Kode Level</th>
            <th>Nama Level</th>
            <td>Aksi</td>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->user_id }}</td>
            <td>{{ $d->username }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->level_id }}</td>
            <td>{{ $d->level->level_kode }}</td> <!-- Mengakses kolom 'level_kode' dari tabel Level -->
            <td>{{ $d->level->level_nama }}</td> <!-- Mengakses kolom 'level_nama' dari tabel Level -->
            <td>
                <a href="/user/ubah/{{ $d->user_id }}">Ubah</a> |

                <!-- Form Hapus -->
                <form action="/user/hapus/{{ $d->user_id }}">Hapus</a></td>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
