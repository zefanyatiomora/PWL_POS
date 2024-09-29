<!DOCTYPE html>
<html>
    <head>
        <title>
            Data User
        </title>
    </head>
    <body>
        <h1>
            Data User
        </h1>
        <a href="{{url('/user/tambah')}}">+ Tambah User</a>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>ID Level Pengguna</th>
                <th>Kode Level</th>
                <th>Nama Level</th>
                <th>Aksi</th>
            </tr>
            @foreach ($data as $d)
                <tr>
                    <td>{{$d -> user_id}}</td>
                    <td>{{$d -> username}}</td>
                    <td>{{$d -> nama}}</td>
                    <td>{{$d -> level_id}}</td>
                    <th>{{$d -> level -> level_kode}}</th>
                    <th>{{$d -> level -> level_nama}}</th>
                    <td> <a href="{{url('/user/ubah')}}/{{$d->user_id}}">Ubah</a> | <a href="{{url('/user/hapus/')}}/{{$d->user_id}}">Hapus</a></td>
                </tr>
                @endforeach
        </table>
    </body>
</html>