<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poliklinik extends Model
{
    use HasFactory;

    protected $table = 'poliklinik';
    protected $primaryKey = 'kd_poli';
    public $incrementing = false;
    public $timestamps = false;

    public function regPeriksa()
    {
        return $this->hasMany(RegPeriksa::class, 'kd_poli', 'kd_poli');
    }
}
