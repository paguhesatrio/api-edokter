<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarRadiologi extends Model
{

    protected $table = 'gambar_radiologi';
    protected $primaryKey = 'no_rawat';
    public $incrementing = false;
    public $timestamps = false;

    public function regperiksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }

    public function hasilRadiologi()
    {
        return $this->hasOne(HasilRadiologi::class, 'tgl_periksa', 'tgl_periksa')
                    ->whereColumn('jam', 'jam');
    }
}
