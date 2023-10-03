<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientesEmail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes_emails';

    protected $fillable = [
        'id',
        'cliente_id',
        'correo',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
