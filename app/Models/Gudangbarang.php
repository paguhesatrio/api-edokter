<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gudangbarang extends Model
{
    use HasFactory;
    protected $table = 'gudangbarang';
    protected $primaryKey = 'kode_brng';
    public $incrementing = false;
    public $timestamps = false;
}
