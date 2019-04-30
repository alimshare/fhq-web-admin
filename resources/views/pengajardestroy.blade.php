@extends('layouts.template')

@section('head-title', 'Detail Pengajar')

@section('title', 'FHQ An-nashr')

@section('body')
     {{ json_encode($pengajar) }}
@endsection