<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopularityScore extends Model
{
    use HasFactory;

    protected $fillable = ['term', 'source_type', 'positive_count', 'negative_count', 'score'];

    protected $casts = [
        'positive_count' => 'integer',
        'negative_count' => 'integer',
        'score' => 'integer'
    ];
}
