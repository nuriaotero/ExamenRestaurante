<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TramoHorario extends Model
{
    protected $table = 'tramos_horarios';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'hora_inicio',
        'hora_fin',
        'activo',
    ];
}
