<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoliosCotizaciones extends Model
{
    use HasFactory;

    protected $table = 'folios_cotizaciones';

    protected $fillable = [
        'id',
        'created_at',
        'updated_at'
    ];
}
