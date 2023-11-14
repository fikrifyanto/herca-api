<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    use HasFactory;

    public function sale()
    {
        return $this->hasMany(Sale::class, 'marketing_id', 'id');
    }
}
