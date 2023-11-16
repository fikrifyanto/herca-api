<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($transactionId): JsonResponse
    {
        try {
            $payments = Payment::where('transaction_id', $transactionId)->paginate();
            $paymentResource = PaymentResource::collection($payments);

            return response()->json(['message' => 'Berhasil menampilkan data pembayaran!', 'data' => $paymentResource], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menampilkan data pembayaran!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request, $transactionId): JsonResponse
    {
        try {
            $payment = new Payment;
            $payment->transaction_id = $request->transaction_id;
            $payment->nominal = $request->nominal;
            $payment->save();

            return response()->json(['message' => 'Berhasil menambahkan pembayaran!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menambahkan pembayaran!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $payment = Payment::find($id);

            if (!$payment) {
                return response()->json(['message' => 'Data pembayaran tidak ditemukan'], 404);
            }

            $paymentResource = new PaymentResource($payment);

            return response()->json(['message' => 'Berhasil menampilkan data pembayaran!', 'data' => $paymentResource], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menampilkan data pembayaran!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentRequest $request, string $id): JsonResponse
    {
        try {
            $payment = Payment::find($id);
            $payment->transaction_id = $request->transaction_id;
            $payment->nominal = $request->nominal;
            $payment->save();

            return response()->json(['message' => 'Berhasil mengupdate pembayaran!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengupdate pembayaran!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            Payment::destroy($id);

            return response()->json(['message' => 'Berhasil menghapus pembayaran!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus pembayaran!', 'error' => $e->getMessage()], 500);
        }
    }
}
