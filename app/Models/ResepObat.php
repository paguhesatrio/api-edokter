<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepObat extends Model
{
    use HasFactory;

    protected $table = 'resep_obat';
    protected $primaryKey = 'no_resep';
    public $incrementing = false;
    public $timestamps = false;

    public function resepDokter()
    {
        return $this->belongsTo(ResepDokter::class, 'no_resep', 'no_resep');
    }
}
