<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Article extends Model
{
    use HasFactory;
    protected $table = 'article';

    protected $fillable = [
        'class',
        'route',
        'title',
        'context',
        'date',
        'image'
    ];

    public function getDateFormattedAttribute(): string
    {
        return Carbon::parse($this->date)->format('M d, Y');
    }

}
