<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Databarang extends Model
{
    protected $table = 'databarang';
    protected $primaryKey = 'kode_brng';
    public $incrementing = false;
    public $timestamps = false;

    public function barang()
    {
        return $this->hasMany(Gudangbarang::class, 'kode_brng', 'kode_brng');
    }

    public function resepDokter()
    {
        return $this->hasMany(ResepDokter::class, 'kode_brng', 'kode_brng');
    }
}
