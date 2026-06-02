<aside class="compass-sidebar">
    <div class="compass-logo">COMPASS</div>

    <div class="mb-4">
        <div class="small text-secondary">Dr. Berlian Rahmy Lidiawaty</div>
        <div class="fw-semibold">Sistem Informasi</div>
    </div>

    <div class="compass-menu-title">MENU</div>

    <a href="{{ route('dashboard') }}" class="compass-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        Dashboard
    </a>

    <a href="{{ route('nilai.index') }}" class="compass-nav-link {{ request()->routeIs('nilai.*') ? 'active' : '' }}">
        Nilai
    </a>

    <a href="{{ route('mata-kuliah.index') }}" class="compass-nav-link {{ request()->routeIs('mata-kuliah.*') ? 'active' : '' }}">
        Mata Kuliah
    </a>

    <a href="{{ route('rps.index') }}" class="compass-nav-link {{ request()->routeIs('rps.*') ? 'active' : '' }}">
        RPS
    </a>

    <div class="position-absolute bottom-0 mb-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm text-white">Log Out</button>
        </form>
    </div>
</aside>
