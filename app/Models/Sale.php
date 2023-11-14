<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public function marketing()
    {
        return $this->belongsTo(Marketing::class, 'id', 'marketing_id');
    }
}
