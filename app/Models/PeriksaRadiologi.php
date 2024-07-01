<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriksaRadiologi extends Model
{
    use HasFactory;

    protected $table = 'periksa_radiologi';
    protected $primaryKey = 'no_rawat ';
    public $incrementing = false;
    public $timestamps = false;

    public function kdjenis()
    {
        return $this->hasMany(JnsPerawatanRadiologi::class, 'kd_jenis_prw', 'kd_jenis_prw');
    }
}
