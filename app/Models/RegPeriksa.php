<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegPeriksa extends Model
{
    protected $table = 'reg_periksa';

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'no_rkm_medis', 'no_rkm_medis');
    }

}
