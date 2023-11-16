<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Marketing;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class OmzetController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $month = $request->input('month', now());
            $year = $request->input('year', now());

            if (!$month || !$year) {
                $omzet = Transaction::with('transaction')->sum('grand_total');
            } else {
                $omzet = Transaction::whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->sum('grand_total');
            }

            return response()->json(['message' => 'Berhasil menampilkan data omzet!', 'omzet' => $omzet], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menampilkan data omzet!', 'error' => $e->getMessage()], 500);
        }
    }
}
