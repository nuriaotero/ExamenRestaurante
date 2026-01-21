<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'username',
        'nombre_completo',
        'email',
        'password',
        'telefono',
        'activo',
    ];
}