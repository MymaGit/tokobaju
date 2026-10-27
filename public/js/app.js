document.addEventListener('click', function (event) {
    const toggle = event.target.closest('[data-toggle-password]');
    if (!toggle) return;

    const input = document.getElementById(toggle.dataset.togglePassword);
    if (!input) return;

    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    toggle.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
    toggle.classList.toggle('is-active', isPassword);
});
