<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrashCategoryPhoto extends Model
{
    use HasFactory;

    public function trash_category()
    {
        return $this->belongsTo(TrashCategory::class);
    }
}
