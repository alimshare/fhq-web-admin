<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Daftar Ulang Berhasil</title>
	<link href="images/fhq-logo.png" type="image/png" rel="icon">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style type="text/css">
    	body, html {
		  height: 100%;
		}

		* {
		  box-sizing: border-box;
		}

		.bg-image {
		  /* The image used */
		  background-image: url("/images/fhq-bg.jpg");

		  /* Add the blur effect */
		  filter: blur(4px);
		  -webkit-filter: blur(4px);

		  /* Full height */
		  height: 100%; 

		  /* Center and scale the image nicely */
		  background-position: center;
		  background-repeat: no-repeat;
		  background-size: cover;
		}

		/* Position text in the middle of the page/image */
		.bg-text {
		  background-color: rgb(0,0,0); /* Fallback color */
		  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
		  color: white;
		  font-weight: bold;
		  border: 3px solid #f1f1f1;
		  position: absolute;
		  top: 50%;
		  left: 50%;
		  transform: translate(-50%, -50%);
		  z-index: 2;
		  width: 80%;
		  padding: 20px;
		  text-align: center;
		}
    </style>
</head>
<body>
	<div class="bg-image"></div>

	<div class="bg-text">
	  <h1>Terima Kasih sudah Daftar Ulang</h1>
	  <hr>

	  <p class="lead mt-3">
	  	Sampai Jumpa di Semester Selanjutnya
	  </p>

	  <hr>

  		Butuh Bantuan / Memiliki Pertanyaan terkait Daftar Ulang ?	<br>
	  	<small class="">Silahkan hubungi kami via Whatsapp</small> 
	  	<br><a
                        href="https://wa.me/6285772710207?text=Assalamualaykum kak, saya mau izin tanya tentang *Daftar Ulang* di FHQ"
                        style="text-decoration: none">085772710207</a> (Desiana/ Admin FHQ)
	  	<br>
	  	<br>

	  	<a class="btn btn-primary btn-sm" href="{{ route('public.du.form', ['semester'=>36, 'hash'=>sha1('fhq.35.du')]) }}" role="button">Kembali ke Beranda</a>
	  <br>
	</div>
</div>

