<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hewan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function shobulqurban(){
        return $this->hasMany(ShobulQurban::class);
    }

    public function master_hewan(){
        return $this->belongsTo(MasterHewan::class);
    }
}
