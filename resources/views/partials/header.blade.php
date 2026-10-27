@php
    $active = $active ?? '';
@endphp

<header class="site-header">
    <div class="site-header__inner">
        <a href="{{ route('home') }}" aria-label="Gavin Fashion Store">
            @include('partials.brand', ['variant' => 'light'])
        </a>

        <nav class="site-nav" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" class="{{ $active === 'beranda' ? 'is-active' : '' }}">Beranda</a>
            <a href="#" class="is-disabled" title="Segera hadir">Katalog</a>
            <a href="#" class="is-disabled" title="Segera hadir">Kategori</a>
            <a href="#" class="is-disabled" title="Segera hadir">Pesanan Saya</a>
        </nav>

        <div class="site-header__actions">
            <span class="icon-btn" title="Keranjang" aria-hidden="true">
                <svg viewBox="0 0 24 24"><path d="M6 8h12l-1.2 11.2a1.6 1.6 0 0 1-1.6 1.4H8.8a1.6 1.6 0 0 1-1.6-1.4L6 8Z"/><path d="M9.2 8V6.4a2.8 2.8 0 0 1 5.6 0V8"/></svg>
            </span>

            @auth
                <span class="user-pill">
                    <span class="user-pill__dot"></span>
                    {{ auth()->user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="icon-btn" title="Keluar" aria-label="Keluar">
                        <svg viewBox="0 0 24 24"><path d="M14.5 8.5V6a1.5 1.5 0 0 0-1.5-1.5H6A1.5 1.5 0 0 0 4.5 6v12A1.5 1.5 0 0 0 6 19.5h7a1.5 1.5 0 0 0 1.5-1.5v-2.5"/><path d="M10 12h9.5"/><path d="M16.5 8.8 19.7 12l-3.2 3.2"/></svg>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="user-pill">Masuk / Daftar</a>
            @endauth
        </div>
    </div>
</header>
