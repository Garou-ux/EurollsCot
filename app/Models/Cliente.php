<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes';

    protected $fillable = [
        'id',
        'nombre',
        'direccion',
        'codigo_postal',
        'created_by',
        'image_path',
        'correo',
        'deleted_by',
        'company_id',
        'telefono',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
