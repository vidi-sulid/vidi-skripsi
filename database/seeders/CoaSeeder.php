<?php

namespace Database\Seeders;

use App\Models\Master\Coa;
use App\Models\Master\Member;
use App\Models\Master\ProductLoan;
use App\Models\Master\ProductSaving;
use App\Models\Master\Saving;
use App\Models\Transaksi\Journal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data  = [
            ["code" => 1, "name" => "Aktiva", "type" => 1],
            ["code" => 2, "name" => "Pasiva", "type" => 1],
            ["code" => 3, "name" => "Ekuitas", "type" => 1],
            ["code" => 4, "name" => "Pendapatan", "type" => 1],
            ["code" => 5, "name" => "Beban", "type" => 1],
            ["code" => '1.100', "name" => "Kas", "type" => 1],
            ["code" => '1.100.10', "name" => "Kas Besar", "type" => 0],
            ["code" => '1.100.20', "name" => "Kas Teller", "type" => 0],
            ["code" => '1.110', "name" => "Penempatan Pada Bank Lain", "type" => 1],
            ["code" => '1.110.10', "name" => "BCA", "type" => 0],
            ["code" => '1.110.20', "name" => "BRI", "type" => 0],
            ["code" => '1.120', "name" => "Pinjaman Anggota", "type" => 1],
            ["code" => '1.120.10', "name" => "Modal Kerja", "type" => 0],
            ["code" => '1.150', "name" => "Aset Inventaris", "type" => 1],
            ["code" => '1.150.10', "name" => "Aset Inventaris Perlengkapan Kantor", "type" => 0],
            ["code" => '1.151', "name" => "Akumulasi Penyusutan Aset Inventaris", "type" => 1],
            ["code" => '1.151.10', "name" => "Akumulasi Penyusutan Aset Inventaris", "type" => 0],
            ["code" => '1.160', "name" => "Aset Lainnya", "type" => 1],
            ["code" => '1.160.10', "name" => "Materai", "type" => 0],

            ['kode' => "3.100", 'name' => 'Simpanan Anggota', "type" => 1],
            ['kode' => "3.100.10", 'name' => 'Simpanan Pokok', "type" => 0],
            ['kode' => "3.100.20", 'name' => 'Simpanan Wajib', "type" => 0],

            ['kode' => "3.200", 'name' => 'Dana Cadangan', "type" => 1],
            ['kode' => "3.200.10", 'name' => 'Dana Cadangan', "type" => 0],

            ['code' => '3.500', 'name' => 'SHU', 'type' => 1],
            ['code' => '3.500.01', 'name' => 'SHU', 'type' => 0],

            ["code" => '4.100', "name" => "Pendapatan Simpanan ", "type" => 1],
            ["code" => '4.100.10', "name" => "Pendapatan Administrasi", "type" => 0],

            ["code" => '4.200', "name" => "Pendapatan Pinjaman ", "type" => 1],
            ["code" => '4.200.10', "name" => "Pendapatan Administrasi", "type" => 0],
            ["code" => '4.200.20', "name" => "Pendapatan Provisi", "type" => 0],
            ["code" => '4.200.30', "name" => "Pendapatan Bunga", "type" => 0],

            ["code" => '4.490', "name" => "Pendapatan Lainnya ", "type" => 1],
            ["code" => '4.490.10', "name" => "Pendapatan Lainnya ", "type" => 0],


            ["code" => '4.500', "name" => "Pendapatan Non Operasional ", "type" => 1],
            ["code" => '4.500.10', "name" => "Pendapatan Non Operasional ", "type" => 0],


            ["code" => '5.100', "name" => "Beban Penyusutan ", "type" => 1],
            ["code" => '5.100.10', "name" => "Beban Penyususutan Aset Iventaris", "type" => 0],
            ["code" => '5.110', "name" => "Beban Simpanan ", "type" => 1],
            ["code" => '5.110.20', "name" => "Beban Simpanan", "type" => 0],


        ];
        Coa::insert($data);

        $invoice = invoice("SAW", true);
        $vaJournal =  [
            [
                "invoice"     => $invoice,
                "date"        => "2000-01-01",
                "rekening"    => "3.200.10",
                "description" => "Dana Cadangan",
                "debit"       => 0,
                "credit"      => 4000000000,
                "username"  => 'system'
            ], [
                "invoice"     => $invoice,
                "date"        => "2000-01-01",
                "rekening"    => "1.100.20",
                "description" => "Dana Cadangan",
                "debit"       => 4000000000,
                "credit"      => 0,
                "username"  => 'system'
            ]
        ];
        Journal::insert($vaJournal);

        $vaProduct = [
            [
                "code" => 'SP_01', "name" => "Simpanan Pokok", "account_saving" => "3.100.10", "account_income_administration" => "4.100.10", "account_cost" => "5.110.20",
                "principal_deposit" => 10000, "mandatory_deposit" => 5000, "type" => "P"
            ],
            [
                "code" => 'SP_02', "name" => "Simpanan Wajib", "account_saving" => "3.100.20", "account_income_administration" => "4.100.10", "account_cost" => "5.110.20",
                "principal_deposit" => 10000, "mandatory_deposit" => 5000, "type" => "W"
            ]
        ];

        ProductSaving::insert($vaProduct);
        $vaProduct = [
            [
                "code" => 'PJ_01', "name" => "Modal Kerja", "account_loan" => "1.120.10", "account_income_administration" => "4.200.10", "account_income_interest" => "4.200.30",
                "account_dutystamp" => "1.160.10",
            ],
            [
                "code" => 'PJ_02', "name" => "Umum", "account_loan" => "1.120.10", "account_income_administration" => "4.200.10", "account_income_interest" => "4.200.30",
                "account_dutystamp" => "1.160.10",
            ]
        ];
        ProductLoan::insert($vaProduct);

        $vaRekening = [
            "rekening" => "01.SP_01.0000001.001",
            "date_open" => date("Y-m-d"),
            "product_saving_id" => "SP_01",
            "member_code" => "0000001",
            "username" => "system"
        ];
        Saving::create($vaRekening);
        $vaRekening = [
            "rekening" => "01.SP_02.0000001.001",
            "date_open" => date("Y-m-d"),
            "product_saving_id" => "SP_02",
            "member_code" => "0000001",
            "username" => "system"
        ];
        Saving::create($vaRekening);
    }
}