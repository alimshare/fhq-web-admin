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

    <title>Daftar</title>

    <!-- Icons -->
    <link href="css/simple-line-icons.min.css" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="css/login.css" rel="stylesheet">

</head>

<body class="app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <h1>Daftar</h1>
                            <p class="text-muted">Buat Akun Baru</p>
                            @if(session()->has('login_error'))
                                <div class="alert alert-warning alert-dismissible" id="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="document.getElementById('alert').remove()">×</button>
                                    {{ session('login_error') }}
                                </div>
                            @endif

                            <div class="input-group mb-3">
                                <span class="input-group-addon"><i class="icon-phone"></i></span>
                                <input id="phone" type="text" class="form-control" name="phone" value="" required autofocus placeholder="Nomor Handphone">
                            </div>
                            @if ($errors->has('phone'))
                                <p class="invalid-feedback">
                                    {{ $errors->first('phone') }}
                                </p>
                            @endif

                            <div class="input-group mb-3">
                                <span class="input-group-addon"><i class="icon-envelope"></i></span>
                                <input id="email" type="email" class="form-control" name="email" value="" required autofocus placeholder="Email">
                            </div>
                            @if ($errors->has('email'))
                                <p class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif

                            <div class="input-group mb-4">
                                <span class="input-group-addon"><i class="icon-lock"></i></span>
                                <input id="password" type="password" class="form-control" name="password" required placeholder="Password" value="">
                            </div>
                            @if ($errors->has('password'))
                                <p class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </p>
                            @endif

                            <div class="input-group mb-4">
                                <span class="input-group-addon"><i class="icon-lock"></i></span>
                                <input id="password" type="password" class="form-control" name="password" required placeholder="Confirm Password" value="">
                            </div>
                            @if ($errors->has('confirm-password'))
                                <p class="invalid-feedback">
                                    {{ $errors->first('confirm-password') }}
                                </p>
                            @endif


                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-lg btn-success px-4">Daftar</button>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="/" class="btn btn-lg btn-light">Kembali</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
