<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataAkademik extends Model
{
    protected $table = 'data_akademik';

    protected $fillable = [
        'kurikulum',
        'angkatan',
        'periode_akademik',
        'kode_dosen',
    ];
}
