<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShobulQurban extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function master_hewan(){
        return $this->belongsTo(MasterHewan::class);
    }

    public function hewan(){
        return $this->belongsTo(Hewan::class);
    }

    public function qurban(){
        return $this->belongsTo(Qurban::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
