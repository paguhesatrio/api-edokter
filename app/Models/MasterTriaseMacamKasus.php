<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTriaseMacamKasus extends Model
{
    protected $table = 'master_triase_macam_kasus';
    protected $primaryKey = 'kode_kasus';
    public $incrementing = false;
    public $timestamps = false;

    public function DataTriaseIgd()
    {
        return $this->hasMany(DataTriaseIgd::class, 'kode_kasus', 'kode_kasus');
    }
}
