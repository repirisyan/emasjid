<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qurban extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function hewan(){
        return $this->belongsTo(Hewan::class);
    }

    public function master_hewan(){
        return $this->belongsTo(MasterHewan::class);
    }

    public function shobul_qurban(){
        return $this->hasMany(ShobulQurban::class);
    }

}
