<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsPerawatanRadiologi extends Model
{
    use HasFactory;
    protected $table = 'jns_perawatan_radiologi';
    protected $primaryKey = 'kd_jenis_prw';
    public $incrementing = false;
    public $timestamps = false;

    public function kdjenis()
    {
        return $this->belongsTo(PeriksaRadiologi::class, 'kd_jenis_prw', 'kd_jenis_prw');
    }

}
