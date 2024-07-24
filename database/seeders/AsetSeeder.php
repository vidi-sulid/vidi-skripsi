<?php

namespace Database\Seeders;

use App\Models\Master\ProductAset;
use App\Models\Transaksi\Aset;
use App\Models\Transaksi\AsetMutation;
use Illuminate\Database\Seeder;

class AsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $vaProduct = [
            [
                "code" => 'AS_01', "name" => "Aset Peralatan", "account_aset" => "1.150.10", "account_depreciation" => "1.151.10", "account_cost" => "5.300.10",
                "account_income" => "4.300.10"
            ],
            [
                "code" => 'AS_02', "name" => "Aset Kendaraan", "account_aset" => "1.152.10", "account_depreciation" => "1.153.10", "account_cost" => "5.300.20",
                "account_income" => "4.300.10"
            ]
        ];
        ProductAset::insert($vaProduct);
        Aset::factory()->count(100)->create();
        $mutasi = Aset::get()->toArray();
        foreach ($mutasi as $data) {
            $invoice = $data['invoice'];
            $vaMutasi = array(
                "invoice" => $invoice,
                "asset_id" => $data['code'],
                "date" => $data['purchase_date'],
                "username" => $data['username'],
                "description" => "Pembelian aset " . $data['name'],
                "debit_price" => $data['price'],
                "debit_book_value" => $data['price']
            );
            AsetMutation::create($vaMutasi);
            UpdAset($invoice);
        }
    }
}
