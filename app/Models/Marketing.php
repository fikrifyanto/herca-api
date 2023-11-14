<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    use HasFactory;

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'marketing_id', 'id');
    }

    public function commitionPercent($month = null, $year = null)
    {
        if (!$month || !$year) {
            $month = now();
            $year = now();
        }

        $omzet = $this->transaction()
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('grand_total');

        if ($omzet < 100000000) {
            return 0;
        } else if ($omzet >= 100000000 && $omzet < 200000000) {
            return 2.5;
        } else if ($omzet >= 200000000 && $omzet < 500000000) {
            return 5;
        } else {
            return 10;
        }
    }
}
