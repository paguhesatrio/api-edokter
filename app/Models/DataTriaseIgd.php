<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTriaseIgd extends Model
{
    protected $table = 'data_triase_igd';
    protected $primaryKey = 'no_rawat';
    public $incrementing = false;
    public $timestamps = false;

    public function kasus()
    {
        return $this->belongsTo(MasterTriaseMacamKasus::class, 'kode_kasus', 'kode_kasus');
    }

    public function igdpremier()
    {
        return $this->belongsTo(DataTriaseIgdPrimer::class, 'no_rawat', 'no_rawat');
    }

    public function igdsekunder()
    {
        return $this->belongsTo(DataTriaseIgdSekunder::class, 'no_rawat', 'no_rawat');
    }

}
