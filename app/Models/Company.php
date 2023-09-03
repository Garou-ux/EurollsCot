<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'companies';

    protected $fillable = [
        'id',
        'name',
        'description',
        'image_path',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
