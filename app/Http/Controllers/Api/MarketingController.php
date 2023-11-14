<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarketingRequest;
use App\Http\Resources\MarketingResource;
use App\Models\Marketing;
use Illuminate\Http\JsonResponse;

class MarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $marketings = Marketing::paginate();
            $marketingResource = MarketingResource::collection($marketings);

            return response()->json(['message' => 'Berhasil menampilkan data marketing!', 'data' => $marketingResource], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menampilkan data marketing!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MarketingRequest $request): JsonResponse
    {
        try {
            $marketing = new Marketing;
            $marketing->name = $request->name;
            $marketing->save();

            return response()->json(['message' => 'Berhasil menambahkan marketing!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menambahkan marketing!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $marketing = Marketing::find($id);

            if (!$marketing) {
                return response()->json(['message' => 'Data marketing tidak ditemukan'], 404);
            }

            $marketingResource = new MarketingResource($marketing);

            return response()->json(['message' => 'Berhasil menampilkan data marketing!', 'data' => $marketingResource], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menampilkan data marketing!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MarketingRequest $request, string $id): JsonResponse
    {
        try {
            $marketing = Marketing::find($id);
            $marketing->name = $request->name;
            $marketing->save();

            return response()->json(['message' => 'Berhasil mengupdate marketing!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengupdate marketing!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            Marketing::destroy($id);

            return response()->json(['message' => 'Berhasil menghapus marketing!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus marketing!', 'error' => $e->getMessage()], 500);
        }
    }
}
