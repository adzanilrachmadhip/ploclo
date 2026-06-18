<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $table = 'mata_kuliah';
    protected $primaryKey = 'id_mk';

    protected $fillable = [
        'kode_mk',
        'nama_matakuliah',
        'sks',
        'semester',
        'tahun_kurikulum',
        'jenis_mata_kuliah',
        'file_rps',
    ];

    public function clos()
    {
        return $this->hasMany(Clo::class, 'id_mk', 'id_mk');
    }
}
