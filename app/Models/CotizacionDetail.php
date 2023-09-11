<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CotizacionDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cotizacion_details';

    protected $fillable = [
        'id',
        'cotizacion_id',
        'producto_id',
        'cantidad',
        'precio',
        'importe',
        'deleted_by',
        'comentario',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
