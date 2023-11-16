<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Marketing;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CommitionController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $marketings = Marketing::with('transaction')->get();

            $commitions = $marketings->map(function ($marketing) {
                $marketing->omzet = $marketing->transaction->sum('grand_total');
                $marketing->commitionPercent = $this->getCommitionPercent($marketing->omzet);
                $marketing->commitionNominal = ($marketing->omzet / 100) * $marketing->commitionPercent;
                $marketing->month = Carbon::parse($marketing->transaction->first()->date)->format('F Y');
                unset($marketing->transaction);
                return $marketing;
            });

            return response()->json(['message' => 'Berhasil menampilkan data komisi!', 'data' => $commitions], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menampilkan data komisi!', 'error' => $e->getMessage()], 500);
        }
    }

    private function getCommitionPercent(int $omzet)
    {
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
