@extends('layout.app')

@section('content')
<div class="min-h-screen flex flex-col lg:flex-row font-oxygen bg-white">
    <!-- Left panel -->
    <div class="relative flex-1 flex flex-col overflow-hidden bg-white px-8 py-6 lg:px-16 lg:py-8 min-h-[50vh] lg:min-h-screen">
        <!-- Decorative large circle -->
        <div
            class="absolute rounded-full bg-[#A1A7FF] pointer-events-none"
            style="
                width: clamp(180px, 21vw, 301px);
                height: clamp(180px, 21vw, 301px);
                left: clamp(20px, 3.6vw, 52px);
                top: clamp(120px, 22vh, 206px);
            "
        ></div>

        <!-- Decorative small circle -->
        <div
            class="absolute rounded-full bg-[#A1A7FF] pointer-events-none"
            style="
                width: clamp(70px, 9vw, 130px);
                height: clamp(70px, 9vw, 130px);
                left: clamp(30%, 45%, 49%);
                bottom: clamp(40px, 8vh, 100px);
            "
        ></div>

        <!-- Logos -->
        <div class="flex items-center gap-4 relative z-10">
            <img
                src="https://api.builder.io/api/v1/image/assets/TEMP/f9ee92e93351fc09bfbd18b117a5cbf1f7a2b8ce?width=196"
                alt="Sistem Informasi logo"
                class="h-16 w-auto object-contain"
            />
            <img
                src="https://api.builder.io/api/v1/image/assets/TEMP/64010ff9f345b19bb00f968568b45ef39f91ba44?width=184"
                alt="Telkom University Surabaya logo"
                class="h-16 w-auto object-contain"
            />
        </div>

        <!-- Main text content -->
        <div class="relative z-10 mt-auto pb-16 lg:pb-24">
            <h1 class="font-overpass font-bold uppercase text-black leading-none"
                style="font-size: clamp(52px, 9.7vw, 140px)">
                COMPASS
            </h1>
            <p class="font-overpass font-bold uppercase text-black mt-4"
                style="font-size: clamp(14px, 2.2vw, 32px); max-width: 800px; line-height: 1.3">
                Automatisasi PLo<br class="hidden sm:block" />
                SISTEM INFORMASI TELKOM UNIVERSITY SURABAYA
            </p>
        </div>
    </div>

    <!-- Right panel - login form -->
    <div
        class="w-full lg:w-[424px] lg:min-w-[380px] flex flex-col items-center justify-center px-8 py-12 lg:py-16 relative"
        style="background: #C2AEFB; box-shadow: 0 4px 10px 10px rgba(0,0,0,0.25)"
    >
        <!-- Welcome heading -->
        <div class="text-center mb-10 w-full" style="max-width: 320px">
            <p class="font-oxygen text-black" style="font-size: clamp(20px, 2.2vw, 32px)">
                WELCOME TO
            </p>
            <p class="font-oxygen text-black font-normal leading-tight"
                style="font-size: clamp(40px, 4.4vw, 64px)">
                COMPASS
            </p>
        </div>

        <!-- Error Message -->
        @if ($errors->any())
            <div class="w-full mb-4 p-4 bg-red-200 border border-red-500 text-red-700 rounded-[7px]" style="max-width: 348px">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('error'))
            <div class="w-full mb-4 p-4 bg-red-200 border border-red-500 text-red-700 rounded-[7px]" style="max-width: 348px">
                {{ session('error') }}
            </div>
        @endif

        <!-- Login form -->
        <form action="{{ route('login') }}" method="POST" class="w-full" style="max-width: 348px">
            @csrf

            <!-- Username -->
            <div class="mb-6">
                <label class="block font-oxygen text-black mb-2" style="font-size: clamp(16px, 1.7vw, 24px)">
                    Username:
                </label>
                <div class="relative">
                    <input
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        class="w-full h-10 rounded-[7px] border-[3px] border-black/80 bg-[rgba(217,217,217,0.70)] px-3 outline-none focus:border-black transition-colors @error('username') border-red-500 @enderror"
                        required
                    />
                    <span class="absolute right-2 top-1/2 -translate-y-1/2">
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 15C16.2979 15 17.5667 14.6151 18.6459 13.894C19.7251 13.1729 20.5663 12.148 21.063 10.9489C21.5597 9.74972 21.6896 8.43022 21.4364 7.15722C21.1832 5.88422 20.5582 4.7149 19.6404 3.79711C18.7226 2.87933 17.5533 2.25432 16.2803 2.0011C15.0073 1.74788 13.6878 1.87784 12.4886 2.37454C11.2895 2.87124 10.2646 3.71238 9.54348 4.79157C8.82238 5.87077 8.4375 7.13956 8.4375 8.4375C8.4375 10.178 9.1289 11.8472 10.3596 13.0779C11.5903 14.3086 13.2595 15 15 15ZM15 16.875C10.9324 16.875 2.8125 19.3875 2.8125 24.375V28.125H27.1875V24.375C27.1875 19.3875 19.0676 16.875 15 16.875Z" fill="#151414"/>
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-8">
                <label class="block font-oxygen text-black mb-2" style="font-size: clamp(16px, 1.7vw, 24px)">
                    Password:
                </label>
                <div class="relative">
                    <input
                        type="password"
                        name="password"
                        id="passwordInput"
                        class="w-full h-10 rounded-[7px] border-[3px] border-black/80 bg-[rgba(217,217,217,0.78)] px-3 outline-none focus:border-black transition-colors @error('password') border-red-500 @enderror"
                        required
                    />
                    <button
                        type="button"
                        onclick="togglePasswordVisibility()"
                        class="absolute right-2 top-1/2 -translate-y-1/2 focus:outline-none"
                        aria-label="Toggle password visibility"
                    >
                        <svg id="eyeIcon" width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.0054 24.8875C23.8746 24.8875 30 17.7197 30 15.4804C30 13.2298 23.8639 6.07324 15.0054 6.07324C6.25714 6.07271 0 13.2293 0 15.4798C0 17.7191 6.24589 24.8875 15.0054 24.8875ZM15.0054 23.1523C7.78286 23.1523 1.92107 17.027 1.92107 15.4793C1.92107 14.1732 7.78286 7.80681 15.0054 7.80681C22.2064 7.80681 28.0789 14.1732 28.0789 15.4793C28.0789 17.0275 22.2064 23.1523 15.0054 23.1523ZM15.0054 21.6266C18.4195 21.6266 21.1634 18.8275 21.1634 15.4793C21.1634 12.0438 18.4195 9.33253 15.0054 9.33253C11.5698 9.33253 8.81464 12.0432 8.83661 15.4793C8.84732 18.8275 11.5698 21.6266 15.0054 21.6266ZM15.0054 17.5215C13.8643 17.5215 12.9418 16.599 12.9418 15.4793C12.9418 14.349 13.8637 13.4382 15.0054 13.4382C16.1357 13.4382 17.0582 14.349 17.0582 15.4793C17.0582 16.599 16.1362 17.5215 15.0054 17.5215Z" fill="#191818"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Login button -->
            <button
                type="submit"
                class="w-full h-14 rounded-[7px] bg-[#0F0F0F] text-[#FFFBFB] font-overpass font-bold tracking-wide hover:bg-black transition-colors"
                style="font-size: clamp(16px, 1.7vw, 24px)"
            >
                LOGIN
            </button>
        </form>
    </div>
</div>

<script>
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('passwordInput');
    const eyeIcon = document.getElementById('eyeIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        // Ganti ikon eye (buka)
        eyeIcon.innerHTML = '<path d="M15.0054 24.8875C23.8746 24.8875 30 17.7197 30 15.4804C30 13.2298 23.8639 6.07324 15.0054 6.07324C6.25714 6.07271 0 13.2293 0 15.4798C0 17.7191 6.24589 24.8875 15.0054 24.8875ZM15.0054 23.1523C7.78286 23.1523 1.92107 17.027 1.92107 15.4793C1.92107 14.1732 7.78286 7.80681 15.0054 7.80681C22.2064 7.80681 28.0789 14.1732 28.0789 15.4793C28.0789 17.0275 22.2064 23.1523 15.0054 23.1523ZM15.0054 21.6266C18.4195 21.6266 21.1634 18.8275 21.1634 15.4793C21.1634 12.0438 18.4195 9.33253 15.0054 9.33253C11.5698 9.33253 8.81464 12.0432 8.83661 15.4793C8.84732 18.8275 11.5698 21.6266 15.0054 21.6266ZM15.0054 17.5215C13.8643 17.5215 12.9418 16.599 12.9418 15.4793C12.9418 14.349 13.8637 13.4382 15.0054 13.4382C16.1357 13.4382 17.0582 14.349 17.0582 15.4793C17.0582 16.599 16.1362 17.5215 15.0054 17.5215Z" fill="#191818"/>';
    } else {
        passwordInput.type = 'password';
    }
}
</script>
@endsection
