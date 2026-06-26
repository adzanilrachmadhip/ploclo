@extends('layout.guest_nw')

@section('title', 'Login - COMPASS')

@section('styles')
    @vite('resources/css/login.css')
@endsection

@section('content')
    <div class="login-page">
        <div class="login-wrapper">
            <div class="login-left">
                <div class="login-logo-group">
                    <img src="{{ asset('images/logo-si.png') }}" alt="Sistem Informasi" class="login-logo">
                    <img src="{{ asset('images/logo-telkom.png') }}" alt="Telkom University" class="login-logo">
                </div>

                <div id="balls-canvas" class="balls-canvas"></div>

                <div class="login-brand">
                    <h1>COMPASS</h1>
                    <h2>
                        Curriculum Outcomes Mapping,<br>
                        Performances and Assesment Systems
                    </h2>
                </div>

            </div>

            <div class="login-right">
                <div class="login-box">
                    <h3>WELCOME TO</h3>
                    <h1>COMPASS</h1>

                    @if (session('error'))
                        <p class="login-error-message">User and Password Not Match!</p>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Username:</label>
                            <div class="login-input-group">
                                <input type="text" name="username" class="form-control login-input"
                                    value="{{ old('username') }}" required autofocus>
                                <span class="login-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 30 30" fill="none">
                                        <path d="M15 15C16.2979 15 17.5667 14.6151 18.6459 13.894C19.7251 13.1729 20.5663 12.148 21.063 10.9489C21.5597 9.74972 21.6896 8.43022 21.4364 7.15722C21.1832 5.88422 20.5582 4.7149 19.6404 3.79711C18.7226 2.87933 17.5533 2.25432 16.2803 2.0011C15.0073 1.74788 13.6878 1.87784 12.4886 2.37454C11.2895 2.87124 10.2646 3.71238 9.54348 4.79157C8.82238 5.87077 8.4375 7.13956 8.4375 8.4375C8.4375 10.178 9.1289 11.8472 10.3596 13.0779C11.5903 14.3086 13.2595 15 15 15ZM15 16.875C10.9324 16.875 2.8125 19.3875 2.8125 24.375V28.125H27.1875V24.375C27.1875 19.3875 19.0676 16.875 15 16.875Z" fill="#151414"/>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password:</label>
                            <div class="login-input-group">
                                <input type="password" name="password" class="form-control login-input" required>
                                <span class="login-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                        <path d="M15 21.25C15.663 21.25 16.2989 20.9866 16.7678 20.5178C17.2366 20.0489 17.5 19.413 17.5 18.75C17.5 18.087 17.2366 17.4511 16.7678 16.9822C16.2989 16.5134 15.663 16.25 15 16.25C14.337 16.25 13.7011 16.5134 13.2322 16.9822C12.7634 17.4511 12.5 18.087 12.5 18.75C12.5 19.413 12.7634 20.0489 13.2322 20.5178C13.7011 20.9866 14.337 21.25 15 21.25ZM22.5 10C23.163 10 23.7989 10.2634 24.2678 10.7322C24.7366 11.2011 25 11.837 25 12.5V25C25 25.663 24.7366 26.2989 24.2678 26.7678C23.7989 27.2366 23.163 27.5 22.5 27.5H7.5C6.83696 27.5 6.20107 27.2366 5.73223 26.7678C5.26339 26.2989 5 25.663 5 25V12.5C5 11.837 5.26339 11.2011 5.73223 10.7322C6.20107 10.2634 6.83696 10 7.5 10H8.75V7.5C8.75 5.8424 9.40848 4.25269 10.5806 3.08058C11.7527 1.90848 13.3424 1.25 15 1.25C16.6576 1.25 18.2473 1.90848 19.4194 3.08058C20.5915 4.25269 21.25 5.8424 21.25 7.5V10H22.5ZM15 3.75C14.0054 3.75 13.0516 4.14509 12.3483 4.84835C11.6451 5.55161 11.25 6.50544 11.25 7.5V10H18.75V7.5C18.75 6.50544 18.3549 5.55161 17.6517 4.84835C16.9484 4.14509 15.9946 3.75 15 3.75Z" fill="black"/>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="btn login-button w-100">LOGIN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
(function () {
    const canvas = document.getElementById('balls-canvas');

    // Palette harmonis: purple → indigo → lavender → cornflower
    // Semua masih dalam family ungu-biru, tidak saling nabrak
    const palette = [
        { color: 'rgba(153, 157, 247, 0.82)', size: 260 }, // periwinkle — besar
        { color: 'rgba(196, 190, 255, 0.70)', size: 180 }, // lavender muda
        { color: 'rgba(118, 124, 232, 0.76)', size: 135 }, // indigo medium
        { color: 'rgba(185, 208, 255, 0.68)', size: 105 }, // cornflower
        { color: 'rgba(213, 195, 255, 0.72)', size:  78 }, // lilac
        { color: 'rgba(160, 196, 255, 0.65)', size:  58 }, // sky blue mini
        { color: 'rgba(172, 158, 248, 0.78)', size:  95 }, // violet medium
    ];

    let W, H;
    const balls = [];

    function resize() {
        W = canvas.offsetWidth;
        H = canvas.offsetHeight;
    }

    function rand(min, max) { return Math.random() * (max - min) + min; }

    function initBalls() {
        canvas.innerHTML = '';
        balls.length = 0;
        resize();

        palette.forEach(({ color, size }) => {
            const el = document.createElement('div');
            el.className = 'ball';
            el.style.cssText = [
                'width:'  + size + 'px',
                'height:' + size + 'px',
                'background:' + color,
                // blur tipis di bola besar untuk efek depth
                size > 150 ? 'filter:blur(1px)' : '',
            ].filter(Boolean).join(';');

            const x = rand(0, Math.max(10, W - size));
            const y = rand(0, Math.max(10, H - size));

            // Bola kecil sedikit lebih cepat → terasa hidup
            const baseSpeed = rand(0.30, 0.65);
            const sizeFactor = 1 + (260 - size) / 400;
            const speed = baseSpeed * sizeFactor;
            const angle = rand(0, Math.PI * 2);

            balls.push({
                el, size,
                x, y,
                vx: Math.cos(angle) * speed,
                vy: Math.sin(angle) * speed,
            });

            canvas.appendChild(el);
            el.style.transform = 'translate3d(' + x + 'px,' + y + 'px,0)';
        });
    }

    function animate() {
        const len = balls.length;
        for (let i = 0; i < len; i++) {
            const b = balls[i];
            b.x += b.vx;
            b.y += b.vy;

            if (b.x <= 0)          { b.x = 0;          b.vx =  Math.abs(b.vx); }
            if (b.x >= W - b.size) { b.x = W - b.size; b.vx = -Math.abs(b.vx); }
            if (b.y <= 0)          { b.y = 0;          b.vy =  Math.abs(b.vy); }
            if (b.y >= H - b.size) { b.y = H - b.size; b.vy = -Math.abs(b.vy); }

            b.el.style.transform = 'translate3d(' + b.x + 'px,' + b.y + 'px,0)';
        }
        requestAnimationFrame(animate);
    }

    window.addEventListener('resize', function () {
        resize();
        balls.forEach(function (b) {
            b.x = Math.min(b.x, Math.max(0, W - b.size));
            b.y = Math.min(b.y, Math.max(0, H - b.size));
        });
    });

    if (document.readyState === 'complete') {
        initBalls(); animate();
    } else {
        window.addEventListener('load', function () { initBalls(); animate(); });
    }
})();
</script>
@endsection
