<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepDokter extends Model
{
    use HasFactory;

    protected $table = 'resep_dokter';
    protected $primaryKey = 'no_resep';

    public function resepObat()
    {
        return $this->belongsTo(ResepObat::class, 'no_resep', 'no_resep');
    }

    public function detailObat()
    {
        return $this->belongsTo(Databarang::class, 'kode_brng', 'kode_brng');
    }
}
