<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SholatJumat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function imam(){
        return $this->belongsTo(User::class,'imam_id','id');
    }

    public function khotib(){
        return $this->belongsTo(User::class,'khotib_id','id');
    }
}
