<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';
    protected $primaryKey = 'kd_dokter';
    public $incrementing = false;
    public $timestamps = false;

    public function ReqPeriksa()
    {
        return $this->hasMany(RegPeriksa::class, 'kd_dokter', 'kd_dokter');
    }
}
