<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSaldo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function keuangan(){
        return $this->hasMany(Keuangan::class);
    }
}
