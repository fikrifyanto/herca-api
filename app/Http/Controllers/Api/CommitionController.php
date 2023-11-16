<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Marketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CommitionController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $month = $request->input('month', now());
            $year = $request->input('year', now());

            if (!$month || !$year) {
                $marketings = Marketing::with('transaction')->get();
            } else {
                $marketings = Marketing::with(['transaction' => function ($query) use ($month, $year) {
                    $query->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year);
                }])->get();
            }

            $commitions = $marketings->map(function ($marketing) {
                $marketing->omzet = $marketing->transaction->sum('grand_total');
                $marketing->commitionPercent = $this->getCommitionPercent($marketing->omzet);
                $marketing->commitionNominal = ($marketing->omzet / 100) * $marketing->commitionPercent;
                $marketing->month = $marketing->created_at->format('F');
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
