<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shortener extends Model
{
    use HasFactory;
    protected $table = 'url_shorteners';

    protected $fillable = [
        'generated_url',
        'actual_url',
    ];
}
