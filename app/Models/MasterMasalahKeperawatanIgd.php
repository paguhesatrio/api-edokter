<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMasalahKeperawatanIgd extends Model
{
    use HasFactory;

    protected $table = 'master_masalah_keperawatan_igd';
    protected $primaryKey = 'kode_masalah';
    public $incrementing = false;
    public $timestamps = false;
}
