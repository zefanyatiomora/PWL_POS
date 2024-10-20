@empty($stok)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-warning">Kembali</a> <!-- Tombol untuk kembali ke halaman sebelumnya -->
        </div>
    </div>
</div>
@else
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Data Stok</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-sm table-bordered table-striped">
                <tr>
                    <th class="text-right col-3">ID Stok:</th>
                    <td class="col-9">{{ $stok->stok_id }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Supplier:</th>
                    <td class="col-9">{{ $stok->supplier->supplier_nama }}</td> <!-- Pastikan relasi supplier ada -->
                </tr>
                <tr>
                    <th class="text-right col-3">Barang:</th>
                    <td class="col-9">{{ $stok->barang->barang_nama }}</td> <!-- Pastikan relasi barang ada -->
                </tr>
                <tr>
                    <th class="text-right col-3">Tanggal Stok:</th>
                    <td class="col-9">{{ $stok->stok_tanggal }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Jumlah Stok:</th>
                    <td class="col-9">{{ $stok->stok_jumlah }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Tutup</button>
        </div>
    </div>
</div>
@endempty
