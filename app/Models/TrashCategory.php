<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrashCategory extends Model
{
    use HasFactory;

    public function photos()
    {
        return $this->hasMany(TrashCategoryPhoto::class, 'trash_category_id');
    }
}
