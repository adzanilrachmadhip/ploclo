@extends('layout.app')

@section('title', 'Manage PLO Mata Kuliah')

@vite([
    'resources/css/dashboard.css',
    'resources/css/mata_kuliah.css'
])

@section('content')

<div class="dashboard-page">

    @include('components.sidebar_nw')

    <main class="dashboard-main">

        {{-- HEADER --}}
        <header class="dashboard-header">
            <button class="mobile-menu-btn" onclick="toggleSidebar()">☰</button>

            <h1>Mata Kuliah</h1>

            <div class="header-actions">
                <input type="text" placeholder="Search">

                <span class="notif">3</span>
                <div class="avatar"></div>
                <span>⌄</span>
            </div>
        </header>

        {{-- CONTENT --}}
        <section class="mk-wrapper">

            <div class="mk-title-bar">
                <span>📝</span>
                <p>Kelola Mata Kuliah</p>
            </div>

            {{-- FILTER --}}
            <div class="mk-filter-area">

                <div class="mk-filter-group">
                    <label>Tahun Kurikulum</label>

                    <select>
                        <option>2024</option>
                    </select>
                </div>

                <div class="mk-filter-group">
                    <label>Kode Mata Kuliah</label>

                    <select>
                        <option>BBK1AAB4</option>
                    </select>
                </div>

                <div class="mk-filter-group">
                    <label>Nama Mata Kuliah</label>

                    <select>
                        <option>ALGORITMA DAN PEMROGRAMAN</option>
                    </select>
                </div>

            </div>

            {{-- INFO --}}
            <div class="mk-info-box">
                Tempat Info
            </div>

            {{-- ADD BUTTON --}}
            <div class="mk-add-btn-wrap">
                <button class="mk-add-btn">
                    + Add PLO
                </button>
            </div>

            {{-- ALERT --}}
            <div class="mk-alert-success"></div>

            {{-- TABLE TOP --}}
            <div class="mk-table-top">
                <div class="record-pages">
                    <span class="record-box"></span>
                    <p>Record per pages</p>
                </div>

                <div class="table-search">
                    <label>Search (Press Enter):</label>
                    <input type="text">
                </div>
            </div>

            {{-- TABLE --}}
            <div class="mk-table-wrapper">

                <table class="mk-table">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>PLO</th>
                            <th>Total CLO</th>
                            <th>Status Aktif PLO Pemetaan</th>
                            <th>Status Aktif PLO</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>1</td>

                            <td class="plo-desc">
                                PLO 01 Mampu menganalisis permasalahan infokom
                                yang kompleks, mendefinisikan, dan memodelkan
                                kebutuhan dalam konteks enterprise atau masyarakat
                                dengan menerapkan ilmu dan pengetahuan dalam bidang
                                komputasi, teknologi informasi dan komunikasi,
                                dan disiplin lain yang relevan
                            </td>

                            <td>30</td>

                            <td>Active</td>

                            <td>Active</td>

                            <td>
                                <button class="btn-edit">
                                    Edit
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                    </tbody>

                </table>

            </div>

            <div class="mk-pagination">

                <button>First</button>
                <button>Previous</button>

                <button class="active">1</button>

                <button>2</button>
                <button>3</button>
                <button>4</button>

                <button>Next</button>
                <button>Last</button>

            </div>

        </section>

    </main>

</div>

<div id="sidebarOverlay" class="sidebar-overlay"></div>

<script>
    function toggleSidebar() {
        document.querySelector('.dashboard-sidebar').classList.toggle('show');
        document.querySelector('.sidebar-overlay').classList.toggle('show');
    }
</script>

@endsection
