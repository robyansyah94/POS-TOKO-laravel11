<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- AdminLTE 2 style -->
  <link rel="stylesheet" href="{{ asset('assets')}}/dist/css/AdminLTE.min.css">

  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('assets')}}/plugins/iCheck/square/blue.css">

  <style>
    body {
      background-color: #f4f6f9;
    }

    .login-wrapper {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .login-logo {
      margin-bottom: 20px;
    }

    .login-card {
      width: 100%;
      max-width: 400px;
    }

    .input-group-text {
      background-color: #f1f1f1;
    }
  </style>
</head>

<body class="hold-transition login-page">
  <div class="login-wrapper">

    <!-- Logo -->
    <div class="login-logo">
      <a href="{{ asset('assets')}}/index2.html"><b>Market</b>by</a>
    </div>

    <!-- Login Card -->
    <div class="card shadow login-card p-4">
      <h4 class="text-center mb-4">Sign In to Your Account</h4>

      <form action="{{ url('login') }}" method="post">
        {{ csrf_field() }}

        <div class="form-group">
          <label for="username">Username</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
          </div>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
          </div>
        </div>

        <div class="form-group d-flex justify-content-between align-items-center">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Remember me</label>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Log In</button>
      </form>

    </div>
  </div>

  <!-- jQuery -->
  <script src="{{ asset('assets')}}/plugins/jQuery/jquery-2.2.3.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- iCheck -->
  <script src="{{ asset('assets')}}/plugins/iCheck/icheck.min.js"></script>
  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
      });
    });
  </script>
</body>

</html>