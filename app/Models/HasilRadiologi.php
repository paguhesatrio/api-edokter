<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilRadiologi extends Model
{
    use HasFactory;
    protected $table = 'hasil_radiologi';
    protected $primaryKey = 'no_rawat';

    public function regperiksa()
    {
        return $this->belongsTo(Regperiksa::class, 'no_rawat', 'no_rawat');
    }

}
