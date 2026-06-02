@extends('layout.app')

@section('title', 'Login - COMPASS')
@vite('resources/css/login.css')
@section('content')
    <div class="login-page">
        <div class="login-wrapper">
            <div class="login-left">
                <div class="login-logo-group">
                    <img src="{{ asset('images/logo-si.png') }}" alt="Sistem Informasi" class="login-logo">
                    <img src="{{ asset('images/logo-telkom.png') }}" alt="Telkom University" class="login-logo">
                </div>

                <div class="circle circle-large"></div>

                <div class="login-brand">
                    <h1>COMPASS</h1>
                    <h2>
                        AUTOMATISASI PLO<br>
                        SISTEM INFORMASI TELKOM UNIVERSITY SURABAYA
                    </h2>
                </div>

                <div class="circle circle-small"></div>
            </div>

            <div class="login-right">
                <div class="login-box">
                    <h3>WELCOME TO</h3>
                    <h1>COMPASS</h1>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Username:</label>
                            <div class="login-input-group">
                                <input type="text" name="username" class="form-control login-input" required autofocus>

                                <span class="login-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                                        viewBox="0 0 30 30" fill="none">
                                        <path
                                            d="M15 15C16.2979 15 17.5667 14.6151 18.6459 13.894C19.7251 13.1729 20.5663 12.148 21.063 10.9489C21.5597 9.74972 21.6896 8.43022 21.4364 7.15722C21.1832 5.88422 20.5582 4.7149 19.6404 3.79711C18.7226 2.87933 17.5533 2.25432 16.2803 2.0011C15.0073 1.74788 13.6878 1.87784 12.4886 2.37454C11.2895 2.87124 10.2646 3.71238 9.54348 4.79157C8.82238 5.87077 8.4375 7.13956 8.4375 8.4375C8.4375 10.178 9.1289 11.8472 10.3596 13.0779C11.5903 14.3086 13.2595 15 15 15ZM15 16.875C10.9324 16.875 2.8125 19.3875 2.8125 24.375V28.125H27.1875V24.375C27.1875 19.3875 19.0676 16.875 15 16.875Z"
                                            fill="#151414" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password:</label>
                            <div class="login-input-group">
                                <input type="password" name="password" class="form-control login-input" required>

                                <span class="login-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                                        viewBox="0 0 30 30" fill="none">
                                        <path
                                            d="M15.0054 24.887C23.8746 24.887 30 17.7192 30 15.4799C30 13.2294 23.8639 6.07275 15.0054 6.07275C6.25714 6.07222 0 13.2288 0 15.4794C0 17.7186 6.24589 24.887 15.0054 24.887ZM15.0054 23.1519C7.78286 23.1519 1.92107 17.0265 1.92107 15.4788C1.92107 14.1728 7.78286 7.80632 15.0054 7.80632C22.2064 7.80632 28.0789 14.1728 28.0789 15.4788C28.0789 17.027 22.2064 23.1519 15.0054 23.1519ZM15.0054 21.6261C18.4195 21.6261 21.1634 18.827 21.1634 15.4788C21.1634 12.0433 18.4195 9.33204 15.0054 9.33204C11.5698 9.33204 8.81464 12.0428 8.83661 15.4788C8.84732 18.827 11.5698 21.6261 15.0054 21.6261ZM15.0054 17.521C13.8643 17.521 12.9418 16.5985 12.9418 15.4788C12.9418 14.3485 13.8637 13.4378 15.0054 13.4378C16.1357 13.4378 17.0582 14.3485 17.0582 15.4788C17.0582 16.5985 16.1362 17.521 15.0054 17.521Z"
                                            fill="#191818" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="btn login-button w-100">
                            LOGIN
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
