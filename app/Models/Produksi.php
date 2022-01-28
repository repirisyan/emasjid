<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function master_hewan(){
        return $this->belongsTo(MasterHewan::class);
    }
}
