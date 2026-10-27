<footer class="site-footer">
    <div class="site-footer__inner">
        <div class="site-footer__grid">
            <div class="site-footer__brand">
                @include('partials.brand', ['variant' => 'light'])
                <p>Temukan gaya terbaikmu, pakaian pilihan untuk gaya sehari-hari.</p>
            </div>

            <div>
                <h4>Belanja &amp; Kategori</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="#">Katalog</a></li>
                    <li><a href="#">Pesanan Saya</a></li>
                </ul>
            </div>

            <div>
                <h4>Informasi Pesanan</h4>
                <ul>
                    <li>Pembayaran transfer 1&times;24 jam</li>
                    <li>Tidak melayani COD</li>
                    <li>Pengiriman JNE, J&amp;T, GoSend, GoShop</li>
                </ul>
            </div>

            <div>
                <h4>Hubungi Kami</h4>
                <ul>
                    <li>Konfirmasi pembayaran dan pertanyaan pesanan</li>
                    <li>089123-1234-1234</li>
                </ul>
            </div>
        </div>

        <p class="site-footer__copy">&copy; {{ date('Y') }} Gavin Fashion Store. Hak cipta dilindungi.</p>
    </div>
</footer>
