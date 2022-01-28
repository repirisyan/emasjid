<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable 
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function adminlte_profile_url()
    {
        return 'admin/settings';
    }

    public function adminlte_image()
    {
        return asset('storage/profile/' . auth()->user()->picture);
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class);
    }

    public function berita()
    {
        return $this->hasMany(Berita::class);
    }

    public function shobul_qurban()
    {
        return $this->hasMany(ShobulQurban::class);
    }

    public function distribusi()
    {
        return $this->hasMany(Distribusi::class);
    }

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class);
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
