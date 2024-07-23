<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameDirectory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'path', 'image_url', 'description', 'rating', 'released', 'platforms', 'genres'];
}
