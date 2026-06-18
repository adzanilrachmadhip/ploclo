@extends('layout.app_nw')

@section('title', 'Dashboard Admin')

@section('styles')
    @vite('resources/css/dashboard_adm.css')
@endsection

@section('topbar_adm')
    @include('components.topbar_adm', [
        'title' => 'Dashboard Admin',
        'subtitle' => 'Selamat datang di sistem COMPASS',
    ])
@endsection

@section('content')
    @php
        $metrics = $metrics ?? [];
        $completeness = $completeness ?? [];
        $activities = $activities ?? [];

        $usersRoute = \Illuminate\Support\Facades\Route::has('users.index') ? route('users.index') : '#';

        $mataKuliahRoute = \Illuminate\Support\Facades\Route::has('mata-kuliah.index')
            ? route('mata-kuliah.index')
            : '#';
    @endphp

    <div class="admin-page">
        <main class="admin-content">
            <div class="admin-content-header">
                <div>
                    <h2>Overview Data Sistem</h2>
                    <p>Ringkasan data utama dan kelengkapan akademik COMPASS.</p>
                </div>

                <div class="admin-period-card">
                    <div class="period-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
                            <path
                                d="M17.8752 2.1665V5.4165M8.12516 2.1665V5.4165M13.0002 2.1665V5.4165M14.0835 3.7915H11.9168C8.34183 3.7915 6.55433 3.7915 5.44391 4.90192C4.3335 6.01234 4.3335 7.79984 4.3335 11.3748V16.2498C4.3335 19.8248 4.3335 21.6123 5.44391 22.7228C6.55433 23.8332 8.34183 23.8332 11.9168 23.8332H14.0835C17.6585 23.8332 19.446 23.8332 20.5564 22.7228C21.6668 21.6123 21.6668 19.8248 21.6668 16.2498V11.3748C21.6668 7.79984 21.6668 6.01234 20.5564 4.90192C19.446 3.7915 17.6585 3.7915 14.0835 3.7915Z"
                                stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M8.66683 15.1665H13.0002M8.66683 10.8332H17.3335M14.0835 3.7915H11.9168C8.34183 3.7915 6.55433 3.7915 5.44391 4.90192C4.3335 6.01234 4.3335 7.79984 4.3335 11.3748V12.9998C4.3335 16.5748 4.3335 18.3623 5.44391 19.4728C6.55433 20.5832 8.34183 20.5832 11.9168 20.5832H14.0835C17.6585 20.5832 19.446 20.5832 20.5564 19.4728C21.6668 18.3623 21.6668 16.5748 21.6668 12.9998V11.3748C21.6668 7.79984 21.6668 6.01234 20.5564 4.90192C19.446 3.7915 17.6585 3.7915 14.0835 3.7915Z"
                                stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>

                    <div>
                        <span>Periode Akademik Aktif</span>
                        <strong>{{ $metrics['active_period'] ?? '-' }}</strong>
                    </div>

                    <i class="bi bi-chevron-down"></i>
                </div>
            </div>

            <section class="admin-stats-grid">
                <div class="admin-stat-card">
                    <div class="stat-icon blue">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="16" viewBox="0 0 32 16"
                            fill="none">
                            <path
                                d="M0 16V13.9C0 12.9444 0.488889 12.1667 1.46667 11.5667C2.44444 10.9667 3.73333 10.6667 5.33333 10.6667C5.62222 10.6667 5.9 10.6722 6.16667 10.6833C6.43333 10.6944 6.68889 10.7222 6.93333 10.7667C6.62222 11.2333 6.38889 11.7222 6.23333 12.2333C6.07778 12.7444 6 13.2778 6 13.8333V16H0ZM8 16V13.8333C8 13.1222 8.19444 12.4722 8.58333 11.8833C8.97222 11.2944 9.52222 10.7778 10.2333 10.3333C10.9444 9.88889 11.7944 9.55556 12.7833 9.33333C13.7722 9.11111 14.8444 9 16 9C17.1778 9 18.2611 9.11111 19.25 9.33333C20.2389 9.55556 21.0889 9.88889 21.8 10.3333C22.5111 10.7778 23.0556 11.2944 23.4333 11.8833C23.8111 12.4722 24 13.1222 24 13.8333V16H8ZM26 16V13.8333C26 13.2556 25.9278 12.7111 25.7833 12.2C25.6389 11.6889 25.4222 11.2111 25.1333 10.7667C25.3778 10.7222 25.6278 10.6944 25.8833 10.6833C26.1389 10.6722 26.4 10.6667 26.6667 10.6667C28.2667 10.6667 29.5556 10.9611 30.5333 11.55C31.5111 12.1389 32 12.9222 32 13.9V16H26ZM10.8333 13.3333H21.2C20.9778 12.8889 20.3611 12.5 19.35 12.1667C18.3389 11.8333 17.2222 11.6667 16 11.6667C14.7778 11.6667 13.6611 11.8333 12.65 12.1667C11.6389 12.5 11.0333 12.8889 10.8333 13.3333ZM5.33333 9.33333C4.6 9.33333 3.97222 9.07222 3.45 8.55C2.92778 8.02778 2.66667 7.4 2.66667 6.66667C2.66667 5.91111 2.92778 5.27778 3.45 4.76667C3.97222 4.25556 4.6 4 5.33333 4C6.08889 4 6.72222 4.25556 7.23333 4.76667C7.74444 5.27778 8 5.91111 8 6.66667C8 7.4 7.74444 8.02778 7.23333 8.55C6.72222 9.07222 6.08889 9.33333 5.33333 9.33333ZM26.6667 9.33333C25.9333 9.33333 25.3056 9.07222 24.7833 8.55C24.2611 8.02778 24 7.4 24 6.66667C24 5.91111 24.2611 5.27778 24.7833 4.76667C25.3056 4.25556 25.9333 4 26.6667 4C27.4222 4 28.0556 4.25556 28.5667 4.76667C29.0778 5.27778 29.3333 5.91111 29.3333 6.66667C29.3333 7.4 29.0778 8.02778 28.5667 8.55C28.0556 9.07222 27.4222 9.33333 26.6667 9.33333ZM16 8C14.8889 8 13.9444 7.61111 13.1667 6.83333C12.3889 6.05556 12 5.11111 12 4C12 2.86667 12.3889 1.91667 13.1667 1.15C13.9444 0.383333 14.8889 0 16 0C17.1333 0 18.0833 0.383333 18.85 1.15C19.6167 1.91667 20 2.86667 20 4C20 5.11111 19.6167 6.05556 18.85 6.83333C18.0833 7.61111 17.1333 8 16 8ZM16 5.33333C16.3778 5.33333 16.6944 5.20556 16.95 4.95C17.2056 4.69444 17.3333 4.37778 17.3333 4C17.3333 3.62222 17.2056 3.30556 16.95 3.05C16.6944 2.79444 16.3778 2.66667 16 2.66667C15.6222 2.66667 15.3056 2.79444 15.05 3.05C14.7944 3.30556 14.6667 3.62222 14.6667 4C14.6667 4.37778 14.7944 4.69444 15.05 4.95C15.3056 5.20556 15.6222 5.33333 16 5.33333Z"
                                fill="#2563EB" />
                        </svg>
                    </div>

                    <div>
                        <span>Total User</span>
                        <h3>{{ $metrics['total_users'] ?? 0 }}</h3>
                        <p>
                            {{ $metrics['total_admin'] ?? 0 }} Admin,
                            {{ $metrics['total_kaprodi'] ?? 0 }} Kaprodi,
                            {{ $metrics['total_dosen_wali'] ?? 0 }} Dosen Wali
                        </p>
                    </div>
                </div>

                <div class="admin-stat-card">
                    <div class="stat-icon green">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="24" viewBox="0 0 30 24"
                            fill="none">
                            <path
                                d="M14.6667 24L5.33333 18.9333V10.9333L0 8L14.6667 0L29.3333 8V18.6667H26.6667V9.46667L24 10.9333V18.9333L14.6667 24ZM14.6667 12.9333L23.8 8L14.6667 3.06667L5.53333 8L14.6667 12.9333ZM14.6667 20.9667L21.3333 17.3667V12.3333L14.6667 16L8 12.3333V17.3667L14.6667 20.9667Z"
                                fill="#16A34A" />
                        </svg>
                    </div>

                    <div>
                        <span>Total Mahasiswa</span>
                        <h3>{{ $metrics['total_mahasiswa'] ?? 0 }}</h3>
                        <p>Semua angkatan</p>
                    </div>
                </div>

                <div class="admin-stat-card">
                    <div class="stat-icon orange">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="16" viewBox="0 0 32 16"
                            fill="none">
                            <path
                                d="M0 16V13.9C0 12.9444 0.488889 12.1667 1.46667 11.5667C2.44444 10.9667 3.73333 10.6667 5.33333 10.6667C5.62222 10.6667 5.9 10.6722 6.16667 10.6833C6.43333 10.6944 6.68889 10.7222 6.93333 10.7667C6.62222 11.2333 6.38889 11.7222 6.23333 12.2333C6.07778 12.7444 6 13.2778 6 13.8333V16H0ZM8 16V13.8333C8 13.1222 8.19444 12.4722 8.58333 11.8833C8.97222 11.2944 9.52222 10.7778 10.2333 10.3333C10.9444 9.88889 11.7944 9.55556 12.7833 9.33333C13.7722 9.11111 14.8444 9 16 9C17.1778 9 18.2611 9.11111 19.25 9.33333C20.2389 9.55556 21.0889 9.88889 21.8 10.3333C22.5111 10.7778 23.0556 11.2944 23.4333 11.8833C23.8111 12.4722 24 13.1222 24 13.8333V16H8ZM26 16V13.8333C26 13.2556 25.9278 12.7111 25.7833 12.2C25.6389 11.6889 25.4222 11.2111 25.1333 10.7667C25.3778 10.7222 25.6278 10.6944 25.8833 10.6833C26.1389 10.6722 26.4 10.6667 26.6667 10.6667C28.2667 10.6667 29.5556 10.9611 30.5333 11.55C31.5111 12.1389 32 12.9222 32 13.9V16H26ZM10.8333 13.3333H21.2C20.9778 12.8889 20.3611 12.5 19.35 12.1667C18.3389 11.8333 17.2222 11.6667 16 11.6667C14.7778 11.6667 13.6611 11.8333 12.65 12.1667C11.6389 12.5 11.0333 12.8889 10.8333 13.3333ZM5.33333 9.33333C4.6 9.33333 3.97222 9.07222 3.45 8.55C2.92778 8.02778 2.66667 7.4 2.66667 6.66667C2.66667 5.91111 2.92778 5.27778 3.45 4.76667C3.97222 4.25556 4.6 4 5.33333 4C6.08889 4 6.72222 4.25556 7.23333 4.76667C7.74444 5.27778 8 5.91111 8 6.66667C8 7.4 7.74444 8.02778 7.23333 8.55C6.72222 9.07222 6.08889 9.33333 5.33333 9.33333ZM26.6667 9.33333C25.9333 9.33333 25.3056 9.07222 24.7833 8.55C24.2611 8.02778 24 7.4 24 6.66667C24 5.91111 24.2611 5.27778 24.7833 4.76667C25.3056 4.25556 25.9333 4 26.6667 4C27.4222 4 28.0556 4.25556 28.5667 4.76667C29.0778 5.27778 29.3333 5.91111 29.3333 6.66667C29.3333 7.4 29.0778 8.02778 28.5667 8.55C28.0556 9.07222 27.4222 9.33333 26.6667 9.33333ZM16 8C14.8889 8 13.9444 7.61111 13.1667 6.83333C12.3889 6.05556 12 5.11111 12 4C12 2.86667 12.3889 1.91667 13.1667 1.15C13.9444 0.383333 14.8889 0 16 0C17.1333 0 18.0833 0.383333 18.85 1.15C19.6167 1.91667 20 2.86667 20 4C20 5.11111 19.6167 6.05556 18.85 6.83333C18.0833 7.61111 17.1333 8 16 8ZM16 5.33333C16.3778 5.33333 16.6944 5.20556 16.95 4.95C17.2056 4.69444 17.3333 4.37778 17.3333 4C17.3333 3.62222 17.2056 3.30556 16.95 3.05C16.6944 2.79444 16.3778 2.66667 16 2.66667C15.6222 2.66667 15.3056 2.79444 15.05 3.05C14.7944 3.30556 14.6667 3.62222 14.6667 4C14.6667 4.37778 14.7944 4.69444 15.05 4.95C15.3056 5.20556 15.6222 5.33333 16 5.33333Z"
                                fill="#D97706" />
                        </svg>
                    </div>

                    <div>
                        <span>Total Dosen Wali</span>
                        <h3>{{ $metrics['total_dosen_wali'] ?? 0 }}</h3>
                        <p>Dosen wali aktif</p>
                    </div>
                </div>

                <div class="admin-stat-card">
                    <div class="stat-icon purple">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="27" viewBox="0 0 22 27"
                            fill="none">
                            <path
                                d="M2.66667 26.6667C1.93333 26.6667 1.30556 26.4056 0.783333 25.8833C0.261111 25.3611 0 24.7333 0 24V2.66667C0 1.93333 0.261111 1.30556 0.783333 0.783333C1.30556 0.261111 1.93333 0 2.66667 0H18.6667C19.4 0 20.0278 0.261111 20.55 0.783333C21.0722 1.30556 21.3333 1.93333 21.3333 2.66667V24C21.3333 24.7333 21.0722 25.3611 20.55 25.8833C20.0278 26.4056 19.4 26.6667 18.6667 26.6667H2.66667ZM2.66667 24H18.6667V2.66667H16V12L12.6667 10L9.33333 12V2.66667H2.66667V24ZM2.66667 24V2.66667V24ZM9.33333 12L12.6667 10L16 12L12.6667 10L9.33333 12Z"
                                fill="#9333EA" />
                        </svg>
                    </div>

                    <div>
                        <span>Mata Kuliah</span>
                        <h3>{{ $metrics['total_mata_kuliah'] ?? 0 }}</h3>
                        <p>Kurikulum {{ $metrics['tahun_aktif'] ?? '-' }}</p>
                    </div>
                </div>

                <div class="admin-stat-card">
                    <div class="stat-icon cyan">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="27" viewBox="0 0 24 27"
                            fill="none">
                            <path
                                d="M2.66667 26.6667C1.93333 26.6667 1.30556 26.4056 0.783333 25.8833C0.261111 25.3611 0 24.7333 0 24V5.33333C0 4.6 0.261111 3.97222 0.783333 3.45C1.30556 2.92778 1.93333 2.66667 2.66667 2.66667H8.26667C8.55556 1.86667 9.03889 1.22222 9.71667 0.733333C10.3944 0.244444 11.1556 0 12 0C12.8444 0 13.6056 0.244444 14.2833 0.733333C14.9611 1.22222 15.4444 1.86667 15.7333 2.66667H21.3333C22.0667 2.66667 22.6944 2.92778 23.2167 3.45C23.7389 3.97222 24 4.6 24 5.33333V24C24 24.7333 23.7389 25.3611 23.2167 25.8833C22.6944 26.4056 22.0667 26.6667 21.3333 26.6667H2.66667ZM2.66667 24H21.3333V5.33333H2.66667V24ZM5.33333 21.3333H14.6667V18.6667H5.33333V21.3333ZM5.33333 16H18.6667V13.3333H5.33333V16ZM5.33333 10.6667H18.6667V8H5.33333V10.6667ZM12 4.33333C12.2889 4.33333 12.5278 4.23889 12.7167 4.05C12.9056 3.86111 13 3.62222 13 3.33333C13 3.04444 12.9056 2.80556 12.7167 2.61667C12.5278 2.42778 12.2889 2.33333 12 2.33333C11.7111 2.33333 11.4722 2.42778 11.2833 2.61667C11.0944 2.80556 11 3.04444 11 3.33333C11 3.62222 11.0944 3.86111 11.2833 4.05C11.4722 4.23889 11.7111 4.33333 12 4.33333ZM2.66667 24V5.33333V24Z"
                                fill="#0891B2" />
                        </svg>
                    </div>

                    <div>
                        <span>Total RPS</span>
                        <h3>{{ $metrics['total_rps'] ?? 0 }}</h3>
                        <p>RPS terunggah</p>
                    </div>
                </div>

                <div class="admin-stat-card">
                    <div class="stat-icon indigo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="27" viewBox="0 0 22 27"
                            fill="none">
                            <path
                                d="M2.66667 26.6667C1.93333 26.6667 1.30556 26.4056 0.783333 25.8833C0.261111 25.3611 0 24.7333 0 24V2.66667C0 1.93333 0.261111 1.30556 0.783333 0.783333C1.30556 0.261111 1.93333 0 2.66667 0H14.6667L21.3333 6.66667V24C21.3333 24.7333 21.0722 25.3611 20.55 25.8833C20.0278 26.4056 19.4 26.6667 18.6667 26.6667H2.66667ZM2.66667 24H18.6667V8H13.3333V2.66667H2.66667V24ZM10.6667 22.6667C12.1556 22.6667 13.4167 22.1444 14.45 21.1C15.4833 20.0556 16 18.8 16 17.3333V12H13.3333V17.3333C13.3333 18.0667 13.0778 18.6944 12.5667 19.2167C12.0556 19.7389 11.4222 20 10.6667 20C9.93333 20 9.30556 19.7389 8.78333 19.2167C8.26111 18.6944 8 18.0667 8 17.3333V10C8 9.8 8.06667 9.63889 8.2 9.51667C8.33333 9.39444 8.48889 9.33333 8.66667 9.33333C8.86667 9.33333 9.02778 9.39444 9.15 9.51667C9.27222 9.63889 9.33333 9.8 9.33333 10V17.3333H12V10C12 9.06667 11.6778 8.27778 11.0333 7.63333C10.3889 6.98889 9.6 6.66667 8.66667 6.66667C7.73333 6.66667 6.94444 6.98889 6.3 7.63333C5.65556 8.27778 5.33333 9.06667 5.33333 10V17.3333C5.33333 18.8 5.85556 20.0556 6.9 21.1C7.94444 22.1444 9.2 22.6667 10.6667 22.6667ZM2.66667 2.66667V8V2.66667V8V24V2.66667Z"
                                fill="#4F46E5" />
                        </svg>
                    </div>

                    <div>
                        <span>Assessment Tools</span>
                        <h3>{{ $metrics['total_assessment_tools'] ?? 0 }}</h3>
                        <p>Komponen penilaian</p>
                    </div>
                </div>
            </section>

            <section class="admin-middle-grid">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h4>
                            <i class="bi bi-database-check"></i>
                            Kelengkapan Data Akademik
                        </h4>
                    </div>

                    <div class="data-completeness-list">
                        @forelse ($completeness as $item)
                            <div class="data-item {{ !empty($item['full']) ? 'full' : '' }}">
                                <span>{{ $item['label'] ?? '-' }}</span>
                                <span class="status-badge {{ $item['class'] ?? 'danger' }}">
                                    {{ $item['status'] ?? 'Belum Lengkap' }}
                                </span>
                            </div>
                        @empty
                            <div class="data-item full">
                                <span>Data Akademik</span>
                                <span class="status-badge danger">Belum Tersedia</span>
                            </div>
                        @endforelse
                    </div>

                    <div class="admin-progress-summary">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>Total Kelengkapan Data</span>
                            <strong>{{ $metrics['overall_percent'] ?? 0 }}%</strong>
                        </div>

                        <div class="progress admin-progress">
                            <div class="progress-bar" style="width: {{ $metrics['overall_percent'] ?? 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="admin-card-header">
                        <h4>
                            <i class="bi bi-pie-chart-fill"></i>
                            Progress Data Sistem
                        </h4>
                    </div>

                    <div class="progress-circle-wrapper">
                        <div class="progress-circle" style="--percent: {{ $metrics['rps_percent'] ?? 0 }};">
                            <strong>{{ $metrics['rps_percent'] ?? 0 }}%</strong>
                            <span>RPS</span>
                        </div>

                        <div class="progress-circle" style="--percent: {{ $metrics['mapping_percent'] ?? 0 }};">
                            <strong>{{ $metrics['mapping_percent'] ?? 0 }}%</strong>
                            <span>CLO Mapped</span>
                        </div>
                    </div>

                    <div class="progress-label-wrapper">
                        <div>
                            <span>RPS Terunggah</span>
                            <strong>
                                {{ $metrics['total_rps'] ?? 0 }}/{{ $metrics['total_mata_kuliah'] ?? 0 }}
                            </strong>
                        </div>

                        <div>
                            <span>Mapping CLO-PLO</span>
                            <strong>
                                {{ $metrics['mapped_clo'] ?? 0 }}/{{ $metrics['total_clo'] ?? 0 }} CLO
                            </strong>
                        </div>
                    </div>
                </div>
            </section>

            <section class="admin-card admin-activity-card">
                <div class="admin-card-header">
                    <h4>
                        <i class="bi bi-clock-history"></i>
                        Aktivitas Terbaru
                    </h4>

                    <a href="#">Lihat Semua</a>
                </div>

                <div class="table-responsive">
                    <table class="table admin-activity-table mb-0">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Aktivitas</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($activities as $activity)
                                <tr>
                                    <td>{{ $activity['time'] ?? '-' }}</td>
                                    <td>
                                        <span class="activity-dot {{ $activity['color'] ?? 'blue' }}"></span>
                                        {{ $activity['text'] ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">Belum ada aktivitas terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="quick-action-section">
                <div class="quick-action-title">
                    <h4>Quick Action</h4>
                    <div></div>
                </div>

                <div class="quick-action-grid">
                    <a href="{{ $usersRoute }}" class="quick-action-card">
                        <div class="quick-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16"
                                fill="none">
                                <path
                                    d="M17 10V7H14V5H17V2H19V5H22V7H19V10H17ZM8 8C6.9 8 5.95833 7.60833 5.175 6.825C4.39167 6.04167 4 5.1 4 4C4 2.9 4.39167 1.95833 5.175 1.175C5.95833 0.391667 6.9 0 8 0C9.1 0 10.0417 0.391667 10.825 1.175C11.6083 1.95833 12 2.9 12 4C12 5.1 11.6083 6.04167 10.825 6.825C10.0417 7.60833 9.1 8 8 8ZM0 16V13.2C0 12.6333 0.145833 12.1125 0.4375 11.6375C0.729167 11.1625 1.11667 10.8 1.6 10.55C2.63333 10.0333 3.68333 9.64583 4.75 9.3875C5.81667 9.12917 6.9 9 8 9C9.1 9 10.1833 9.12917 11.25 9.3875C12.3167 9.64583 13.3667 10.0333 14.4 10.55C14.8833 10.8 15.2708 11.1625 15.5625 11.6375C15.8542 12.1125 16 12.6333 16 13.2V16H0ZM2 14H14V13.2C14 13.0167 13.9542 12.85 13.8625 12.7C13.7708 12.55 13.65 12.4333 13.5 12.35C12.6 11.9 11.6917 11.5625 10.775 11.3375C9.85833 11.1125 8.93333 11 8 11C7.06667 11 6.14167 11.1125 5.225 11.3375C4.30833 11.5625 3.4 11.9 2.5 12.35C2.35 12.4333 2.22917 12.55 2.1375 12.7C2.04583 12.85 2 13.0167 2 13.2V14ZM8 6C8.55 6 9.02083 5.80417 9.4125 5.4125C9.80417 5.02083 10 4.55 10 4C10 3.45 9.80417 2.97917 9.4125 2.5875C9.02083 2.19583 8.55 2 8 2C7.45 2 6.97917 2.19583 6.5875 2.5875C6.19583 2.97917 6 3.45 6 4C6 4.55 6.19583 5.02083 6.5875 5.4125C6.97917 5.80417 7.45 6 8 6Z"
                                    fill="#2563EB" />
                            </svg>
                        </div>

                        <h5>Tambah User</h5>
                        <p>Tambah akun admin, kaprodi, atau dosen wali.</p>
                    </a>

                    <a href="{{ $mataKuliahRoute }}" class="quick-action-card">
                        <div class="quick-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <path
                                    d="M11 12H13V9H16V7H13V4H11V7H8V9H11V12ZM6 16C5.45 16 4.97917 15.8042 4.5875 15.4125C4.19583 15.0208 4 14.55 4 14V2C4 1.45 4.19583 0.979167 4.5875 0.5875C4.97917 0.195833 5.45 0 6 0H18C18.55 0 19.0208 0.195833 19.4125 0.5875C19.8042 0.979167 20 1.45 20 2V14C20 14.55 19.8042 15.0208 19.4125 15.4125C19.0208 15.8042 18.55 16 18 16H6ZM6 14H18V2H6V14ZM2 20C1.45 20 0.979167 19.8042 0.5875 19.4125C0.195833 19.0208 0 18.55 0 18V4H2V18H16V20H2ZM6 2V14V2Z"
                                    fill="#2563EB" />
                            </svg>
                        </div>

                        <h5>Tambah Mata Kuliah</h5>
                        <p>Tambah mata kuliah baru ke sistem.</p>
                    </a>

                    <a href="#" class="quick-action-card">
                        <div class="quick-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20"
                                fill="none">
                                <path
                                    d="M2 20C1.45 20 0.979167 19.8042 0.5875 19.4125C0.195833 19.0208 0 18.55 0 18V4C0 3.45 0.195833 2.97917 0.5875 2.5875C0.979167 2.19583 1.45 2 2 2H3V0H5V2H13V0H15V2H16C16.55 2 17.0208 2.19583 17.4125 2.5875C17.8042 2.97917 18 3.45 18 4V18C18 18.55 17.8042 19.0208 17.4125 19.4125C17.0208 19.8042 16.55 20 16 20H2ZM2 18H16V8H2V18ZM2 6H16V4H2V6ZM2 6V4V6Z"
                                    fill="#2563EB" />
                            </svg>
                        </div>

                        <h5>Atur Semester</h5>
                        <p>Kelola periode akademik yang aktif.</p>
                    </a>

                    <a href="#" class="quick-action-card">
                        <div class="quick-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18"
                                fill="none">
                                <path
                                    d="M13 18V15H9V5H7V8H0V0H7V3H13V0H20V8H13V5H11V13H13V10H20V18H13ZM2 2V6V2ZM15 12V16V12ZM15 2V6V2ZM15 6H18V2H15V6ZM15 16H18V12H15V16ZM2 6H5V2H2V6Z"
                                    fill="#2563EB" />
                            </svg>
                        </div>

                        <h5>Kelola Kurikulum</h5>
                        <p>Atur mapping CLO-PLO dan ekuivalensi MK.</p>
                    </a>
                </div>
            </section>
        </main>

        <footer class="admin-footer">
            <span>COMPASS - Curriculum Outcomes Mapping, Performance and Assessment System</span>
            <span>© 2026 Telkom University Surabaya</span>
        </footer>
    </div>
@endsection
