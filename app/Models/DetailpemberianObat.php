<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailpemberianObat extends Model
{
    protected $table = 'detail_pemberian_obat';

    public function dataBarang()
    {
        return $this->belongsTo(Databarang::class, 'kode_brng', 'kode_brng');
    }
}
