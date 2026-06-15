<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'COMPASS')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@400;600;700&family=Oxygen:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/compass_nw.css', 'resources/css/dashboard_adm.css', 'resources/css/dashboard_doswal.css', 'resources/css/dashboard.css'])
    @yield('styles')
</head>
<body>
    <div class="compass-wrapper">
        @auth
            @include('components.sidebar_nw')
            <div class="sidebar-overlay" onclick="closeSidebar()"></div>
        @endauth

        <div class="compass-main">
            @auth
                @hasSection('topbar_adm')
                    @yield('topbar_adm')
                @else
                    @include('components.header_nw', [
                        'title' => trim($__env->yieldContent('headerTitle')) ?: ($headerTitle ?? 'COMPASS'),
                        'searchLabel' => 'Search', ])
                @endif
            @endauth
            <main class="compass-content">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.querySelector('.dashboard-sidebar')?.classList.toggle('show');
            document.querySelector('.sidebar-overlay')?.classList.toggle('show');
        }
        function closeSidebar() {
            document.querySelector('.dashboard-sidebar')?.classList.remove('show');
            document.querySelector('.sidebar-overlay')?.classList.remove('show');
        }
    </script>
    @yield('scripts')
</body>
</html>
