@extends('layout.app')

@section('content')

<div class="container">

    <div class="header">
        <h2>Data Akademik</h2>
    </div>

    {{-- FORM --}}
    <div class="form-section">

        <form action="{{ route('data-akademik.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Kurikulum</label>

                <input type="text"
                       name="kurikulum"
                       value="{{ old('kurikulum') }}">
            </div>

            <div class="form-group">
                <label>Angkatan</label>

                <input type="text"
                       name="angkatan"
                       value="{{ old('angkatan') }}">
            </div>

            <div class="form-group">
                <label>Periode Akademik</label>

                <input type="text"
                       name="periode_akademik"
                       value="{{ old('periode_akademik') }}">
            </div>

            <div class="form-group">
                <label>Kode Dosen</label>

                <input type="text"
                       name="kode_dosen"
                       value="{{ old('kode_dosen') }}">
            </div>

            <div class="button-group">
                <button type="submit" class="btn-save">
                    Simpan
                </button>
            </div>

        </form>

    </div>

    {{-- INFO --}}
    @if(session('success'))
        <div class="info-box">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="table-section">

        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>Kurikulum</th>
                    <th>Angkatan</th>
                    <th>Periode Akademik</th>
                    <th>Kode Dosen</th>
                </tr>
            </thead>

            <tbody>

                @forelse($dataAkademik as $item)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kurikulum }}</td>
                        <td>{{ $item->angkatan }}</td>
                        <td>{{ $item->periode_akademik }}</td>
                        <td>{{ $item->kode_dosen }}</td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5" align="center">
                            Data belum tersedia
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
