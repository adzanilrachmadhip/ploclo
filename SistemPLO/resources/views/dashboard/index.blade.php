@extends('layout.app')

@section('content')
<div class="flex h-screen overflow-hidden bg-slate-100">
    <x-dashboard.sidebar :user="$user" :nav-items="$navItems" />

    <div class="flex-1 min-w-0 flex flex-col">
        <x-dashboard.header title="Dashboard Perhitungan PLO" subtitle="Selamat datang di COMPASS" searchLabel="Search" />

        <main class="flex-1 overflow-y-auto p-4 lg:p-6 xl:p-8">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Overview</h2>
                    <p class="text-sm text-slate-500">Ringkasan utama sistem PLO Anda.</p>
                </div>
                <div class="inline-flex items-center rounded-2xl bg-white px-4 py-3 shadow-sm">
                    <span class="text-sm text-slate-600">Tahun :</span>
                    <span class="ml-2 text-sm font-semibold text-slate-900">2425/1 Genap</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6 mb-6">
                <div class="bg-white rounded-[28px] border border-slate-200 p-6 shadow-sm">
                    <p class="text-slate-500 text-sm font-medium">Total Mahasiswa</p>
                    <p class="text-slate-900 text-4xl font-bold mt-4">150</p>
                </div>
                <div class="bg-white rounded-[28px] border border-slate-200 p-6 shadow-sm">
                    <p class="text-slate-500 text-sm font-medium">Rata-Rata Ketercapaian PLO%</p>
                    <p class="text-slate-900 text-4xl font-bold mt-4">53,6%</p>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-[1.55fr_1fr] gap-4 lg:gap-6">
                <div class="bg-gradient-to-br from-[#F6F5FF] to-[#F7F8FC] rounded-[28px] p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <p class="text-slate-800 text-sm font-semibold">Ketercapaian PLO Angkatan 2024</p>
                            <p class="text-slate-500 text-sm mt-1">Persentase capaian tiap PLO.</p>
                        </div>
                        <span class="rounded-2xl bg-white/80 px-3 py-2 text-xs font-semibold text-slate-700">Acuan 100%</span>
                    </div>

                    <div class="flex gap-3 h-[320px] lg:h-[380px]">
                        <div class="flex flex-col justify-between items-end py-2 w-12 flex-shrink-0">
                            @foreach($yAxisTicks as $tick)
                                <span class="text-[11px] text-slate-500">{{ $tick === 0 ? '0' : $tick . '%' }}</span>
                            @endforeach
                        </div>
                        <div class="flex-1 flex flex-col justify-end">
                            <div class="relative flex-1 pb-7">
                                @for($i = 0; $i < 4; $i++)
                                    <div class="absolute inset-x-0 top-{{ $i * 25 }}% h-px bg-slate-300"></div>
                                @endfor
                                <div class="absolute inset-x-0 bottom-0 flex items-end gap-2 px-0">
                                    @foreach($ploData as $plo)
                                        @php $heightPercent = ($plo['value'] / $chartMax) * 100; @endphp
                                        <div class="flex-1 flex flex-col justify-end items-center group relative">
                                            <div class="w-full max-w-[28px] rounded-t-2xl" style="height:{{ $heightPercent }}%; background:{{ $plo['color'] }}"></div>
                                            <div class="absolute bottom-[calc(100%+8px)] left-1/2 -translate-x-1/2 rounded-full bg-slate-900 text-white text-[10px] px-2 py-1 opacity-0 transition-opacity group-hover:opacity-100">{{ $plo['value'] }}%</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex h-7 items-center gap-1">
                                @foreach($ploData as $plo)
                                    <div class="flex-1 text-center text-[10px] lg:text-[11px] text-slate-500">PLO {{ $loop->iteration }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[28px] p-6 shadow-sm">
                    <h2 class="text-slate-900 text-lg font-semibold mb-4">Hasil Perolehan Nilai Program Outcomes Learning (PLO)</h2>
                    <div class="overflow-hidden rounded-3xl border border-slate-200">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="py-4 px-4 text-sm font-semibold text-slate-700 border-b border-slate-200">PLO</th>
                                    <th class="py-4 px-4 text-sm font-semibold text-slate-700 border-b border-slate-200">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ploData as $plo)
                                    <tr class="odd:bg-slate-50 even:bg-white">
                                        <td class="py-4 px-4 text-sm text-slate-800">{{ $plo['label'] }}</td>
                                        <td class="py-4 px-4 text-sm font-semibold text-slate-900">{{ $plo['value'] }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
