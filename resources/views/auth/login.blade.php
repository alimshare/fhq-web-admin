<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="FHQ - Forum Halaqoh Qur'an">
  <meta name="author" content="IT FHQ">
  <meta name="keyword" content="FHQ, Forum Halaqoh Qur'an, Islam, Al-Qur'an, Tahsin, Takhosus, Tahfidz">
  <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->
  <!-- <link rel="shortcut icon" href="{{ url('/') }}/dist/img/favicon.png"> -->

  <title>{{ env('APP_NAME', 'FHQ') }} - Login</title>

  <!-- Icons -->
  <link href="css/simple-line-icons.min.css" rel="stylesheet">

  <!-- Main styles for this application -->
  <link href="css/login.css" rel="stylesheet">

</head>

<body class="app flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group">
          <div class="card p-4">
            <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
              {{ csrf_field() }}
              <h1>Login</h1>
              <p class="text-muted">Sign In to your account</p>
              
              @if($errors->any())
                <div class="alert alert-warning alert-dismissible" id="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="document.getElementById('alert').remove()">×</button>              
                    @foreach ($errors->all() as $error)
                        <label>{{ $error }}</label>
                    @endforeach
                </div>
              @endif

              <div class="input-group mb-3">
                <span class="input-group-addon"><i class="icon-envelope"></i></span>
                <input id="username" type="text" class="form-control" name="username" value="" required autofocus placeholder="Username">
              </div>

              <div class="input-group mb-4">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input id="password" type="password" class="form-control" name="password" required placeholder="Password" value="">
              </div>


              <div class="row">
                <div class="col-6">
                  <button type="submit" class="btn btn-primary px-4">Sign In</button>
                </div>
                <div class="col-6 text-right">
{{--                  <a href="{{ route('password.request') }}" class="btn btn-link px-0">Forgot password?</a>--}}
{{--                  <a href="{{ route('register') }}" class="btn btn-light">Sign Up</a>--}}
                </div>

              </div>
              </form>
            </div>
          </div>
          <div class="card text-white py-5 d-md-down-none" style="width:44%;background-color: #00bcd4">
            <div class="card-body text-center">
              <div>
                <h2>{{ env('APP_NAME','FHQ') }}</h2>
                <p style="margin-top: 15px">Rasullullah shallallahu 'alaihi wa sallam bersabda, <strong><em>"Sebaik-baik kalian adalah yang belajar Al-Qur'an dan mengajarkannya"</em></strong> (HR. Bukhari)</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
