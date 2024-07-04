<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepDokter extends Model
{
    use HasFactory;
    
    protected $table = 'resep_dokter';
    protected $primaryKey = 'no_resep';
    public $incrementing = false;
    public $timestamps = false;

    public function resepObat()
    {
        return $this->hasMany(ResepObat::class, 'no_resep', 'no_resep');
    }
}
