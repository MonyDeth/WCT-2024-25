<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('payment_methods')->insert([
            [
                'method_name' => 'Cash',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'method_name' => 'KHQR',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'method_name' => 'Credit/Debit Card',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
