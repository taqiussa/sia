@extends('print-no-header')
@section('title', 'Print Analisis Pengetahuan')
@section('content')
    @include('print.guru.print-analisis-cover')
    <div class="[page-break-before:always]"></div>
    @include('print.guru.print-analisis-pengetahuan-isi')
    <div class="[page-break-before:always]"></div>
    @include('print.guru.print-analisis-pengetahuan-rekap')
@endsection
