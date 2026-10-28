<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';

    protected $primaryKey = 'id_pengguna';

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'foto',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'dibuat_pada' => 'datetime',
    ];

    public function getAuthPassword(): string
    {
        return $this->password;
    }
}