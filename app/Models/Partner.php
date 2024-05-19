<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    public function openDays()
    {
        return $this->hasMany(OpenDays::class);
    }
    public function users()
    {
        return $this->hasMany(User::class, 'partner_id');
    }
    public function news()
    {
        return $this->hasMany(News::class, 'partner_id');
    }
}
