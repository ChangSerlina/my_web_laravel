<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    use HasFactory;
    protected $table = 'article';

    protected $fillable = [
        'class',
        'title',
        'context',
        'date',
        'image'
    ];
}
