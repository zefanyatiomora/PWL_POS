<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;


class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table        = 'm_user'; //mendefinisikan nama tabel yang akan digunakan. :o
    protected $primaryKey   = 'user_id'; //mendefinisikan primary key dari tabel yang digunakan. x3

    protected $fillable     = ['level_id', 'username', 'nama', 'password', 'created_at', 'updated_at', 'profile_picture'];

    protected $hidden       = ['password'];

    protected $casts        = ['password' => 'hashed'];

    public function level():BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    //mendapatkan nama role

    public function getRoleName(): string {
        return $this->level->level_nama;
    }

    //cek apakah user memiliki kode tertentu

    public function hasRole($role): bool {
        return $this->level->level_kode == $role;
    }

    //mendapatkan kode role
    public function getRole(): string {
        return $this->level->level_kode;
    }
}
