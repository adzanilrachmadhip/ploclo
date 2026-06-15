<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $navItems = [
            [
                'label' => 'Dashboard',
                'route' => 'admin.dashboard',
                'icon' => 'home',
            ],
            [
                'label' => 'Kelola User',
                'route' => '#',
                'icon' => 'users',
            ],
            [
                'label' => 'Kelola Mahasiswa',
                'route' => '#',
                'icon' => 'users',
            ],
            [
                'label' => 'Kelola Mata Kuliah',
                'route' => '#',
                'icon' => 'book',
            ],
            [
                'label' => 'Kelola Kurikulum',
                'route' => '#',
                'icon' => 'book',
            ],
            [
                'label' => 'RPS',
                'route' => '#',
                'icon' => 'file',
            ],
            [
                'label' => 'Pengaturan Sistem',
                'route' => '#',
                'icon' => 'setting',
            ],
        ];

        return view('admin.dashboard', compact('user', 'navItems'));
    }
}
