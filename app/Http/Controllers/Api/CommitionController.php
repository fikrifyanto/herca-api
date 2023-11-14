<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Marketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CommitionController extends Controller
{
    public function __invoke(Request $request, Marketing $marketing)
    {
        try {
            $month = $request->input('month', now());
            $year = $request->input('year', now());
            $commition = $marketing->commitionPercent($month, $year);

            return response()->json(['message' => 'Berhasil menampilkan data marketing!', 'data' => ['commition_percent' => $commition]], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menampilkan data marketing!', 'error' => $e->getMessage()], 500);
        }
    }
}
