<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    public function photos()
    {
        return $this->hasMany(NewsPhoto::class, 'news_id');
    }
    public function category()
    {
        return $this->belongsTo(NewsCategory::class);
    }
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
