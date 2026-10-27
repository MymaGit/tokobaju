@extends('layouts.site')

@section('title', 'Halaman Penjual')

@section('content')
    <section class="panel">
        <div class="panel__head">
            <h1>Halaman Penjual</h1>
            <p class="muted">
                Anda masuk sebagai penjual dengan akun {{ auth()->user()->identity }}.
                Hak akses pelanggan dan penjual sudah dipisahkan oleh sistem.
            </p>
        </div>

        <div class="alert alert--info">
            Dashboard penjual (produk, stok, pesanan, verifikasi bayar, laporan omzet) dibangun pada tahap berikutnya.
        </div>

        <div class="row">
            <a href="{{ route('home') }}" class="btn btn--ghost">Kembali ke Beranda</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn">Keluar</button>
            </form>
        </div>
    </section>
@endsection