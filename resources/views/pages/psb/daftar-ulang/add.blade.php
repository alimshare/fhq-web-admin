@extends('layouts.materialized')

@section('title', 'Form Daftar Ulang')

@section('content')
    <h1>DU</h1>

    <form action="" method="post">

        NIS
        <input type="number" name="" id=""> 
        
        Nomor HP 
        <input type="text">
        
        <button>Cek</button>

        <h2>Informasi Peserta</h2>
        Nama 
        <input type="text" name="" id="">

        Halaqoh 
        <select name="" id="">
            <option value="">Pilih Halaqoh</option>
        </select>

        Nama Pengajar 
        <input type="text" name="" id="">

        Program 
        <input type="text" name="" id="">

        Hari 
        <input type="text" name="" id="">

        <h2>Informasi Daftar Ulang</h2>

        Pilihan Hari 
        <input type="radio" name="" id=""> Sabtu 
        <input type="radio" name="" id=""> Ahad 

        Pilihan Jenis KBM
        <input type="radio" name="" id=""> Offline 
        <input type="radio" name="" id=""> Online

        Bukti Daftar Ulang 
        <input type="file" name="" id="">


    </form>
@endsection