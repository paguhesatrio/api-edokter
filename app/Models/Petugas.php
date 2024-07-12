<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    public $timestamps = false;

    public function petugas()
    {
        return $this->hasMany(PeriksaRadiologi::class, 'nip', 'nip');
    }
}
