<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now(); // ✅ Define it here before using

        DB::table('payment_methods')->insert([
            [
                'method_name' => 'cash',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'method_name' => 'khqr',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'method_name' => 'credit',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
