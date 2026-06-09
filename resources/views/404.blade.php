<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - COMPASS</title>
    <style>
        body { font-family: 'Oxygen', sans-serif; background: #F2F2F6; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .wrap { text-align: center; }
        h1 { font-size: 96px; font-weight: 700; margin: 0; color: #101C2B; }
        p { font-size: 20px; color: #555; margin: 12px 0 28px; }
        a { background: #101C2B; color: #fff; text-decoration: none; padding: 12px 28px; border-radius: 6px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>404</h1>
        <p>Halaman tidak ditemukan</p>
        <a href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
    </div>
</body>
</html>
