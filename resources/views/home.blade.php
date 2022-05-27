@extends('layouts.master')
@section('header','Dashboard')
@section('dashboard-active','active')

@section('content')
<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
    <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
            <h3 class="mb-3">Selamat Datang {{Auth::user()->name}}</h3>
            <div class="row gx-5 gy-3">
                <div class="col-12 col-lg-9">


                    @if (Auth::user()->is_active == 0)
                    <div>Akun Anda Masih Non Aktif, Hubungi Kami untuk mengaktifkan Akun Anda</div>
                    @else
                    <div>Powered By JuraganAR</div>
                    @endif
                </div>
                <!--//col-->

                <!--//col-->
            </div>
            <!--//row-->
        </div>
        <!--//app-card-body-->

    </div>
    <!--//inner-->
</div>
@if (Auth::user()->is_active == 1)
<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
    <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
            <h3 class="mb-3">Perhatian</h3>
            <div class="row gx-5 gy-3">
                <div class="col-12 col-lg-9">
                    <ol>
                        <li>Setelah Akun Aktif diharapkan ke menu setting untuk mengatur bagian export</li>
                        <li>Bagi yang memakai sistem rumus silakan ke menu manage rumus untuk membuat</li>
                        <li>jika pada rumus tidak dalam jangkauan maka akan keuntungan akan otomatis 0, jadi harus ada
                            jangkauan dari 0
                            hingga angka terbanyak</li>
                    </ol>
                </div>
                <!--//col-->
                <!--//col-->
            </div>
            <!--//row-->
        </div>
        <!--//app-card-body-->

    </div>
    <!--//inner-->
</div>
@endif
<!--//app-card-->
@endsection