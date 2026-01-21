<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'mesa_id',
        'tramo_horario_id',
        'fecha_reserva',
        'numero_personas',
        'comentarios',
        'estado',
    ];
}
