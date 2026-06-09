<header class="dashboard-header">
    <button class="mobile-menu-btn" type="button" onclick="toggleSidebar()">
        <span>☰</span>
    </button>

    <div class="header-title">
        <h1>{{ $title ?? 'Dashboard Perhitungan PLO' }}</h1>
        @isset($subtitle)
            <p>{{ $subtitle }}</p>
        @endisset
    </div>

    <div class="header-actions">
        <input type="text" placeholder="{{ $searchLabel ?? 'Search' }}">
        <span class="notif">3</span>
        <div class="avatar"></div>
        <span class="dropdown-icon">⌄</span>
    </div>
</header>
