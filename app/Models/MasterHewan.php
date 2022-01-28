<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterHewan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function hewan(){
        return $this->hasMany(Hewan::class);
    }

    public function shobul_qurban(){
        return $this->hasMany(ShobulQurban::class);
    }

    public function produksi(){
        return $this->hasMany(Produksi::class);
    }
}
