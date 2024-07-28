<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Admin Login</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('image/logo.png') }}">
  <!-- General CSS Files -->
  <link rel="stylesheet" href="/newAdmin/dist/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/newAdmin/dist/assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="/newAdmin/dist/assets/modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="/newAdmin/dist/assets/css/style.css">
  <link rel="stylesheet" href="/newAdmin/dist/assets/css/components.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
  integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <style>
    .password-container {
      position: relative;
    }
    .password-container input {
      padding-right: 2.5rem;
    }
    .password-container .fa-eye,
    .password-container .fa-eye-slash {
      position: absolute;
      top: 70%;
      right: 1rem;
      transform: translateY(-50%);
      cursor: pointer;
      color: #ccc;
    }
  </style>
</head>
<body>
  @include('sweetalert::alert')
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <h5>BASECAMP</h5>
            </div>

            <div class="card card-primary" >
              <div class="card-header"><h4>Login</h4></div>

              <div class="card-body">
                <form method="POST" action="{{route('admin.auth')}}" class="needs-validation" novalidate="">
                  @csrf
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>

                  <div class="form-group password-container">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <i class="fas fa-eye" id="toggleEye" onclick="togglePassword('password', 'toggleEye')"></i>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" style="background-color:#F0861A !important; border:none !important; box-shadow:none !important;">
                      Login
                    </button>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="/newAdmin/dist/assets/modules/jquery.min.js"></script>
  <script src="/newAdmin/dist/assets/modules/popper.js"></script>
  <script src="/newAdmin/dist/assets/modules/tooltip.js"></script>
  <script src="/newAdmin/dist/assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="/newAdmin/dist/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="/newAdmin/dist/assets/modules/moment.min.js"></script>
  <script src="/newAdmin/dist/assets/js/stisla.js"></script>
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="/newAdmin/dist/assets/js/scripts.js"></script>
  <script src="/newAdmin/dist/assets/js/custom.js"></script>
  <script>
    function togglePassword(inputId, toggleId) {
      const passwordField = document.getElementById(inputId);
      const toggleEye = document.getElementById(toggleId);
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleEye.classList.remove('fa-eye');
        toggleEye.classList.add('fa-eye-slash');
      } else {
        passwordField.type = 'password';
        toggleEye.classList.remove('fa-eye-slash');
        toggleEye.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>
