<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateLaboratorium extends Model
{
    use HasFactory;

    protected $table = 'template_laboratorium';
    protected $primaryKey = 'id_template';  // Assuming 'id_template' is the primary key for template_laboratorium

    public function lab()
    {
        return $this->belongsTo(JnsPerawatanLab::class, 'kd_jenis_prw', 'kd_jenis_prw');
    }
}
