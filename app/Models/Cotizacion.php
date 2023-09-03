<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cotizacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cotizacion';

    protected $fillable = [
        'id',
        'cliente_id',
        'created_by',
        'company_id',
        'status_id',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
