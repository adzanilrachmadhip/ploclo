<header class="admin-topbar">
    <div class="admin-topbar-left">
        <button class="admin-menu-toggle d-lg-none" type="button" id="adminSidebarToggle">
            <i class="bi bi-list"></i>
        </button>

        <div>
            <h1 class="admin-topbar-title">{{ $title ?? 'Dashboard Admin' }}</h1>
            @isset($subtitle)
                <p class="admin-topbar-subtitle">{{ $subtitle }}</p>
            @endisset
        </div>
    </div>

    <div class="admin-topbar-right">
        <button class="admin-notification-btn" type="button">
            <i class="bi bi-bell"></i>
            <span>3</span>
        </button>

        <div class="admin-topbar-profile">
            <div class="admin-profile-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
        </div>
    </div>
</header>
