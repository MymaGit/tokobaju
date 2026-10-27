@php
    $variant = $variant ?? 'dark';
    $stacked = $stacked ?? false;
@endphp

<span class="brand brand--{{ $variant }}{{ $stacked ? ' brand--stacked' : '' }}">
    <svg class="brand__mark" viewBox="0 0 48 48" aria-hidden="true">
        <circle cx="24" cy="24" r="22.4" fill="none" stroke="currentColor" stroke-width="1" opacity=".55"/>
        <path d="M30.6 18.4a8.6 8.6 0 1 0 .7 10.4h-6.9"
              fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <span class="brand__text">
        <span class="brand__name">Gavin</span>
        <span class="brand__sub">Fashion Store</span>
    </span>
</span>
