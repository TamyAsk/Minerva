<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'age',
        'sex',
        'password',
        'rango',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function librosLikes()
    {
        return $this->belongsToMany(Libro::class, 'usuario_libro_like', 'usuario_id', 'fk_libros');
    }

    public function librosVerDespues()
    {
        return $this->belongsToMany(Libro::class, 'usuario_libro_ver_despues', 'usuario_id', 'fk_libros');
    }

    public function librosVistos()
    {
        return $this->belongsToMany(Libro::class, 'usuario_libro_vistos', 'usuario_id', 'fk_libros');
    }

    
    
}
