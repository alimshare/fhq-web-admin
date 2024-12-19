<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <title>Daftar Ulang FHQ</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

    <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/skeleton.css">

    <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="icon" type="image/png" href="images/favicon.png">
    <style>
        a {
            text-decoration: none
        }

        input[type="text"],
        input[type="number"] {
            width: 32rem;
        }

        .w-full {
            width: 100%;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #ccc;
        }

        .no-padding {
            padding: 0
        }

        .text-center {
            text-align: center
        }

        .text-red {
            color: red
        }

        .p-1 {
            padding: 0.25rem;
        }

        table.td-p-1 tr td,
        table.td-p-1 tr th {
            padding: 0.25rem;
        }

        .box-penting {
            outline: 4px double #ffaeae;
            padding: 1.5rem;
            margin-bottom: 1.5em;
            background-color: #ffd1d1;
        }

        .card {
            outline: 1px solid #ddd;
            padding: 1rem;        
        }

        .card.red {
            background-color: #ffaeae;
        }

        pre, blockquote, dl, figure, table, p, ul, ol, form {
            margin-bottom: 1rem;
        }

        .mb-0 {margin-bottom: 0}

        /* The close button */
        .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
        }

        /* When moving the mouse over the close button */
        .closebtn:hover {
        color: black;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="two-thirds column" style="margin-top: 2em;" id="section-form">

                <h2 style="font-size: 2.5rem">Konfirmasi Daftar Ulang</h2>
                <form action="" method="post" style="margin-bottom: 0">
                    @csrf
                    <label for="nis">NIS (Nomor Induk Santri)</label>
                    <input type="number" name="nis" value="{{ $nis ?? '' }}">
                    <button type="submit" class="button button-primary">Cek Kepesertaan</button>
                </form>

                @if (session('alert'))
                    <?php $color = session('alert.type') == 'danger' ? 'red' : 'green'; ?>
                    <div id="card-alert" class="card {{ $color }}  lighten-5">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';" style="cursor: pointer">&times;</span>
                        <div class="card-content {{ $color }}-text">
                            <p class="mb-0">{!! session('alert.message') !!}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div id="card-alert" class="card red lighten-5">
                        <div class="card-content red-text">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                        <span class="closebtn" onclick="this.parentElement.style.display='none';" style="cursor: pointer">&times;</span>
                    </div>
                @endif



                @isset($santri_name)

                    @if($completed)

                    <div class="">
                        <h4 style="font-size: 2.5rem; margin-top:1em; margin-bottom:0.5em">Informasi Daftar Ulang</h4>
                        <table width="w-full" style="margin-bottom:0px">
                            <tr>
                                <td width="25%">NIS</td>
                                <td>{{ $nis ?? '' }}</td>
                            </tr>
                            <tr>
                                <td width="25%">Nama Peserta</td>
                                <td>{{ $santri_name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>                      
                                <td style="vertical-align: middle; color:green">                                    
                                    <svg stroke="#4eb198" fill="#000000" width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 0c-8.836 0-16 7.163-16 16s7.163 16 16 16c8.837 0 16-7.163 16-16s-7.163-16-16-16zM16 30.032c-7.72 0-14-6.312-14-14.032s6.28-14 14-14 14 6.28 14 14-6.28 14.032-14 14.032zM22.386 10.146l-9.388 9.446-4.228-4.227c-0.39-0.39-1.024-0.39-1.415 0s-0.391 1.023 0 1.414l4.95 4.95c0.39 0.39 1.024 0.39 1.415 0 0.045-0.045 0.084-0.094 0.119-0.145l9.962-10.024c0.39-0.39 0.39-1.024 0-1.415s-1.024-0.39-1.415 0z"></path>
                                    </svg> &nbsp; Sudah Daftar Ulang
                                </td>
                            </tr>
                        </table>
                    </div>
                        
                    @else 

                        <form action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <h4 style="font-size: 2.5rem; margin-top:1em; margin-bottom:0.5em">Informasi Peserta</h4>
                            <input type="hidden" name="nis" value="{{ $nis ?? '' }}">
                            <table width="w-full" style="margin-bottom:0px">
                                <tr>
                                    <td width="25%">Nama Peserta</td>
                                    <td>{{ $santri_name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td width="25%">Nomor Handphone</td>
                                    <td>{!! $phone_masking ?? '' !!}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="border-bottom: none;">
                                        <label for="">Daftar Halaqoh</label>

                                        <table class="table table-bordered w-full" style="margin-bottom:0px">
                                            <tr>
                                                <th></th>
                                                <th>Hari</th>
                                                <th>Program</th>
                                                <th>Pengajar</th>
                                                <th>KBM</th>
                                                <th>Semester</th>
                                            </tr>
                                            @foreach ($halaqohList as $item)
                                                <tr>
                                                    <td class="text-center" style="padding:0 10px">
                                                        <input type="radio" name="peserta_id" value="{{ $item->peserta_id }}" @if(count($halaqohList) == 1) checked @endif required>
                                                    </td>
                                                    <td>{{ $item->day }}</td>
                                                    <td>{{ $item->program_name }}</td>
                                                    <td>{{ $item->pengajar_name }}</td>
                                                    <td>{{ empty($item->jenis_kbm) ? 'OFFLINE' : $item->jenis_kbm }}</td>
                                                    <td>{{ $item->semester_id }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                            </table>


                            <h4 style="font-size: 2.5rem; margin-top:1em; margin-bottom:0.5em">Informasi Daftar Ulang</h4>

                            <div class="row" style="margin-bottom: 1em">
                                <div class="three columns"><label>Pilihan Hari</label></div>
                                <div class="nine columns">
                                    <label for="sabtu" style="display: inline-block"><input type="radio" id="sabtu" name="hari" value="SABTU" required>
                                        <span class="label-body">Sabtu</span></label>
                                        &nbsp;&nbsp;&nbsp;
                                    <label for="ahad" style="display: inline-block"><input type="radio" id="ahad" name="hari" value="AHAD">
                                        <span class="label-body">Ahad</span></label>
                                        &nbsp;&nbsp;&nbsp;
                                    <label for="cuti" style="display: inline-block"><input type="radio" id="cuti" name="hari" value="CUTI">
                                        <span class="label-body">Cuti</span></label>
                                </div>
                            </div>


                            <div class="row" style="margin-bottom: 1em" id="row-jenis-kbm">
                                <div class="three columns"><label>Pilihan Jenis KBM</label></div>
                                <div class="nine columns">
                                    <label for="offline" style="display: inline-block"><input type="radio" id="offline" name="jenis_kbm" value="OFFLINE" required>
                                        <span class="label-body">OFFLINE / MRBJ</span></label>
                                        &nbsp;&nbsp;&nbsp;
                                    <label for="online" style="display: inline-block"><input type="radio" id="online" name="jenis_kbm" value="ONLINE">
                                        <span class="label-body">ONLINE</span></label>
                                        &nbsp;&nbsp;&nbsp;
                                    <label for="cuti-kbm" style="display: inline-block"><input type="radio" id="cuti-kbm" name="jenis_kbm" value="CUTI">
                                        <span class="label-body">Cuti</span></label>
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 1em">
                                <div class="three columns"><label for="tgl_lahir">Tanggal Lahir</label></div>
                                <div class="nine columns">
                                    <input type="date" name="tgl_lahir" id="tgl_lahir" required>
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 1em">
                                <div class="three columns"><label>Bukti Daftar Ulang</label></div>
                                <div class="nine columns">
                                    <p>Infaq daftar ulang = <b>Rp 100.036</b></p>

                                    Transfer ke rekening:
                                    <table style="margin-top: 0; margin-bottom:1rem" class="table table-bordered w-full">
                                        <tr>
                                            <td style="padding: 5px">Bank Syariah Indonesia </td>
                                            <td><b>4000777500</b></td>
                                            <td>Yayasan Hamalatul Quran Indonesia </td>
                                        </tr>
                                    </table>

                                    <p>
                                        Konfirmasi via Whatsapp:
                                        <a
                                            href="https://wa.me/6285772710207?text=Assalamu'alaykum kak, saya mau konfirmasi daftar ulang...
                                            style="text-decoration:none;">085772710207</a>
                                        (Desiana/ Admin FHQ)
                                    </p>

                                    Untuk pengajuan penundaan atau pengurangan (Santri Sosial). Harap menghubungi Admin FHQ dan
                                    Upload Surat Keputusan Santri Sosial dari Admin.
                                    <a href="https://wa.me/6285772710207?text=Assalamualaykum kak, saya ingin mengajukan penundaan / pengurangan infaq (*Santri Sosial*) ..."
                                        style="text-decoration: none">Hubungi Admin</a></p>

                                    <div class="box-penting">Bagi kelas Tahsin / Tahfizh Dewasa jika melunasi infaq pendidikan
                                        sebelum tanggal <b>30 Januari 2025</b>, mendapat potongan <b>Rp. 150.000</b>,
                                        sehingga cukup melunasi <b>Rp. 600.000</b> </div>

                                    <input type="file" name="upload" id="upload" accept="image/*" data-target="preview" onchange="loadFile(event, this)" required>
                                    
                                    <img src="" alt="" id="preview" width="200px" style="width: 200px; margin-top:1em;">
                                </div>
                                <div>
                                </div>
                            </div>



                            <input type="submit" class="button button-primary" name="confirm" value="Konfirmasi">

                        </form>
                    @endif

                    @endisset
            </div>

            <div class="one-third column"
                style="margin-top: 2em; outline:1px solid #ccc; padding:1em; box-shadow:8px 12px #888888;"
                id="section-info">
                <h4>Info</h4>
                <p>
                    Periode Daftar Ulang: <b>7 Desember 2024</b> s.d. <b>12 Januari 2025</b>
                </p>

                Infaq Pendidikan per Semester
                <table class="w-full table-bordered td-p-1" style="margin-bottom: 0px; font-size: 0.8em">
                    <tr>
                        <td>Tahsin / Tahfizh Dewasa</td>
                        <td>Rp. 750.000 (<span class="text-red">*</span>)</td>
                    </tr>
                    <tr>
                        <td>Tahsin / Tahfizh Anak</td>
                        <td>Rp. 500.000</td>
                    </tr>
                    <tr>
                        <td>Bahasa Arab</td>
                        <td>Rp. 500.000</td>
                    </tr>
                </table>

                <span class="text-red" style="font-size: 1.2em">*</span>) <small>Potongan Rp. 150.000,- bagi kelas
                    Tahsin /
                    Tahfizh Dewasa jika melunasi infaq pendidikan sebelum tanggal <b>30 Januari 2025</b></small>
                </p>
                <p>
                    Infaq daftar ulang minimal <b>Rp 100.036</b> <br>
                    <span class="text-red" style="font-size: 1.2em">*</span>) <small>Angsuran awal infaq
                        pendidikan semester berikutnya.</small>
                </p>
                <p>
                    Tersedia <b>Program Santri Sosial</b> bagi santri yang memiliki kendala terkait infaq
                    pendidikan.<br><br>
                    Hubungi via Whatsapp: <br><a
                        href="https://wa.me/6285772710207?text=Assalamualaykum kak, saya mau izin tanya tentang *Program Santri Sosial* di FHQ"
                        style="text-decoration: none">085772710207</a> (Desiana/ Admin FHQ)</p>
            </div>

        </div>
    </div>

    <script>


        const loadFile = (event, elem) => {
            var target = elem.getAttribute("data-target");
            var output = document.getElementById(target);

            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) 
            }

        };

    </script>

</body>

</html>
