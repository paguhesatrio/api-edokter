<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeriksaLab extends Model
{
    use HasFactory;

    protected $table = 'detail_periksa_lab';
    protected $primaryKey = 'no_rawat ';
    public $incrementing = false;
    public $timestamps = false;

    public function laboratorium()
    {
        return $this->belongsTo(TemplateLaboratorium::class, 'id_template', 'id_template');
    }
}
