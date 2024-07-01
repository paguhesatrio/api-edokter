<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriksaLab extends Model
{
    use HasFactory; 

    protected $table = 'periksa_lab';
    protected $primaryKey = 'no_rawat ';
    public $incrementing = false;
    public $timestamps = false;

    public function kdjenis()
    {
        return $this->hasMany(JnsPerawatanLab::class, 'kd_jenis_prw', 'kd_jenis_prw');
    }

}
