<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrasi Pengguna</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition register-page">
  <div class="register-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="{{ url('/') }}" class="h1"><b>Admin</b>LTE</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Daftar sebagai pengguna baru</p>
        <form action="{{ url('register') }}" method="POST" id="form-register">
          @csrf
          <div class="input-group mb-3">
            <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
            <small id="error-username" class="error-text text-danger"></small>
          </div>
          <div class="input-group mb-3">
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            <small id="error-email" class="error-text text-danger"></small>
          </div>
          <div class="input-group mb-3">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <small id="error-password" class="error-text text-danger"></small>
          </div>
          <div class="input-group mb-3">
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <small id="error-password_confirmation" class="error-text text-danger"></small>
          </div>
          <div class="row">
            <div class="col-8">
              <a href="{{ route('login') }}" class="text-center">Sudah punya akun? Masuk di sini</a>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Daftar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- jquery-validation -->
  <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
  <!-- SweetAlert2 -->
  <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
  <script>
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(document).ready(function() {
      $("#form-register").validate({
        rules: {
          username: { required: true, minlength: 4, maxlength: 20 },
          email: { required: true, email: true },
          password: { required: true, minlength: 5, maxlength: 20 },
          password_confirmation: { required: true, equalTo: '#password' }
        },
        submitHandler: function(form) {
          // ketika valid, maka bagian yg akan dijalankan
          $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            success: function(response) {
              if (response.status) {
                // jika sukses
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: response.message,
                }).then(function() {
                  window.location = response.redirect;
                });
              } else {
                // jika error
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
          element.closest('.input-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });
  </script>
</body>
</html>
