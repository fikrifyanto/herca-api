<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $transactions = Transaction::with('payment')->with('marketing')->orderBy('created_at', 'desc');

            if ($request->keyword) {
                $transactions = $transactions->where('transaction_number', 'like', "%$request->keyword%");
            }

            $transactions = $transactions->paginate();
            $transactionResource = TransactionResource::collection($transactions);

            return response()->json(['message' => 'Berhasil menampilkan data transaksi!', 'data' => $transactionResource], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menampilkan data transaksi!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request): JsonResponse
    {
        try {
            $currentLength = Transaction::count();

            $transaction = new Transaction;
            $transaction->marketing_id = $request->marketing_id;
            $transaction->transaction_number = $this->generateTransactionNumber($currentLength + 1);
            $transaction->date = $request->date;
            $transaction->cargo_fee = $request->cargo_fee;
            $transaction->total_balance = $request->total_balance;
            $transaction->grand_total = $request->grand_total;
            $transaction->type = $request->type;
            $transaction->save();

            return response()->json(['message' => 'Berhasil menambahkan transaksi!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menambahkan transaksi!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $transaction = Transaction::find($id);

            if (!$transaction) {
                return response()->json(['message' => 'Data transaksi tidak ditemukan'], 404);
            }

            $transactionResource = new TransactionResource($transaction);

            return response()->json(['message' => 'Berhasil menampilkan data transaksi!', 'data' => $transactionResource], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menampilkan data transaksi!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionRequest $request, string $id): JsonResponse
    {
        try {
            $transaction = Transaction::find($id);
            $transaction->marketing_id = $request->marketing_id;
            $transaction->date = $request->date;
            $transaction->cargo_fee = $request->cargo_fee;
            $transaction->total_balance = $request->total_balance;
            $transaction->grand_total = $request->grand_total;
            $transaction->type = $request->type;
            $transaction->save();

            return response()->json(['message' => 'Berhasil mengupdate transaksi!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengupdate transaksi!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            Transaction::destroy($id);

            return response()->json(['message' => 'Berhasil menghapus transaksi!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus transaksi!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Generate transaction number
     */
    function generateTransactionNumber($currentCount): string
    {
        $numberLength = 3;

        $zeroPadding = $numberLength - strlen($currentCount);

        $transactionNumber = 'TRX' . str_repeat('0', $zeroPadding) . $currentCount;

        return $transactionNumber;
    }
}
