<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'clave',
        'nombre',
        'descripcion',
        'precio',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
