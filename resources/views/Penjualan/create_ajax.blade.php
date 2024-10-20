<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-tambah-penjualan">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>User ID</label>
                    <input value="" type="text" name="user_id" id="user_id" class="form-control" required>
                    <small id="error-user_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Pembeli</label>
                    <input value="" type="text" name="pembeli" id="pembeli" class="form-control" required>
                    <small id="error-pembeli" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kode Penjualan</label>
                    <input value="" type="text" name="penjualan_kode" id="penjualan_kode" class="form-control" required>
                    <small id="error-penjualan_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Penjualan</label>
                    <input value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" type="date" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control" required>
                    <small id="error-penjualan_tanggal" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Detail Penjualan</label>
                    <table id="detail-penjualan" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Jual</th>
                                <th>Total Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="barang_id[]" class="form-control barang_id" required>
                                        <option value="">- Pilih Barang -</option>
                                        @foreach($barang as $b)
                                            <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="jumlah[]" class="form-control jumlah" required>
                                </td>
                                <td>
                                    <input type="number" name="harga_jual[]" class="form-control harga_jual" required>
                                </td>
                                <td>
                                    <input type="text" name="total_harga[]" class="form-control total_harga" readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-remove">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" id="btn-tambah-barang" class="btn btn-info">Tambah Barang</button>
                    <small id="error-detail" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Validate form
        $("#form-tambah-penjualan").validate({
            rules: {
                user_id: { required: true },
                pembeli: { required: true },
                penjualan_kode: { required: true },
                penjualan_tanggal: { required: true },
                'barang_id[]': { required: true },
                'jumlah[]': { required: true, number: true, min: 1 },
                'harga_jual[]': { required: true, number: true, min: 1 },
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            // Reload DataTable or any necessary actions
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        // Add item row
        $('#btn-tambah-barang').on('click', function() {
            $('#detail-penjualan tbody').append(`
                <tr>
                    <td>
                        <select name="barang_id[]" class="form-control barang_id" required>
                            <option value="">- Pilih Barang -</option>
                            @foreach($barang as $b)
                                <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="jumlah[]" class="form-control jumlah" required>
                    </td>
                    <td>
                        <input type="number" name="harga_jual[]" class="form-control harga_jual" required>
                    </td>
                    <td>
                        <input type="text" name="total_harga[]" class="form-control total_harga" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-remove">Hapus</button>
                    </td>
                </tr>
            `);
        });

        // Calculate total price
        $(document).on('input', '.jumlah, .harga_jual', function() {
            let row = $(this).closest('tr');
            let jumlah = row.find('.jumlah').val();
            let hargaJual = row.find('.harga_jual').val();
            let total = jumlah * hargaJual;
            row.find('.total_harga').val(total.toFixed(2));
        });

        // Remove item row
        $(document).on('click', '.btn-remove', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
