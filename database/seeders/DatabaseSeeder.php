<?php

namespace Database\Seeders;

use App\Models\Marketing;
use App\Models\Transaction;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Marketing::factory(10)->create()->each(function ($marketing) {
            Transaction::factory(3)->create(['marketing_id' => $marketing->id])->each(function ($transaction) {
                if ($transaction->type == 'cash') {
                    Payment::create([
                        'transaction_id' => $transaction->id, 'nominal' => $transaction->grand_total
                    ]);
                } else if ($transaction->type == 'credit' && $transaction->status == 'paid') {
                    Payment::create([
                        'transaction_id' => $transaction->id, 'nominal' => $transaction->grand_total - (($transaction->grand_total / 100) * 10)
                    ]);
                } else {
                    Payment::create([
                        'transaction_id' => $transaction->id, 'nominal' => $transaction->grand_total - (($transaction->grand_total / 100) * 50)
                    ]);
                    Payment::create([
                        'transaction_id' => $transaction->id, 'nominal' => $transaction->grand_total - (($transaction->grand_total / 100) * 40)
                    ]);
                    Payment::create([
                        'transaction_id' => $transaction->id, 'nominal' => $transaction->grand_total - (($transaction->grand_total / 100) * 20)
                    ]);
                }
            });
        });;
    }
}
