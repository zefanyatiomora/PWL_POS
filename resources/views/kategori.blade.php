<!DOCTYPE html>
<html>
<head>
    <title>Data Kategori Barang</title>
</head>
<body>
    <h1>Data Kategori Barang</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Kode Kategori</th>
            <th>Nama Kategori</th>
        </tr>
        <?php foreach ($data as $d): ?>
        <tr>
            <td><?php echo $d->kategori_id; ?></td>
            <td><?php echo $d->kategori_kode; ?></td>
            <td><?php echo $d->kategori_nama; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>