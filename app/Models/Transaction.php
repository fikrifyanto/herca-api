<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function marketing()
    {
        return $this->hasOne(Marketing::class, 'id', 'marketing_id');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class, 'transaction_id', 'id');
    }
}
