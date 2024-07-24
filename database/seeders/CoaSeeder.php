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
            ["code" => '1.152', "name" => "Aset Kendaraan", "type" => 1],
            ["code" => '1.152.10', "name" => "Aset Kendaraan", "type" => 0],
            ["code" => '1.153', "name" => "Akumulasi Penyusutan Aset Kendaraan", "type" => 1],
            ["code" => '1.153.10', "name" => "Akumulasi Penyusutan Aset Kendaraan", "type" => 0],
            ["code" => '1.160', "name" => "Aset Persediaan", "type" => 1],
            ["code" => '1.160.10', "name" => "Materai", "type" => 0],
            ["code" => '1.161', "name" => "Beban Dibayar di Muka", "type" => 1],
            ["code" => '1.161.10', "name" => "Asuransi Dibayar di Muka", "type" => 0],
            ["code" => '1.161.20', "name" => "Sewa Dibayar di Muka", "type" => 0],
            ["code" => '1.162', "name" => "Uang Muka", "type" => 1],
            ["code" => '1.162.10', "name" => " Uang Muka Pembelian", "type" => 0],
            ["code" => '1.162.20', "name" => " Uang Muka Karyawan", "type" => 0],

            ['kode' => "2.100", 'name' => 'Kewajiban  Jangka Pendek', "type" => 1],
            ['kode' => "2.100.10", 'name' => 'Utang Usaha', "type" => 0],
            ['kode' => "2.100.11", 'name' => 'Utang Pajak', "type" => 0],
            ['kode' => "2.100.12", 'name' => 'Utang Pinjaman', "type" => 0],

            ['kode' => "2.110", 'name' => 'Kewajiban  Jangka Panjang', "type" => 1],
            ['kode' => "2.110.10", 'name' => 'Utang Bank Jangka Panjang', "type" => 0],


            ['kode' => "3.100", 'name' => 'Simpanan Anggota', "type" => 1],
            ['kode' => "3.100.10", 'name' => 'Simpanan Pokok', "type" => 0],
            ['kode' => "3.100.20", 'name' => 'Simpanan Wajib', "type" => 0],

            ['kode' => "3.200", 'name' => 'Dana Cadangan', "type" => 1],
            ['kode' => "3.200.10", 'name' => 'Dana Cadangan', "type" => 0],

            ['code' => '3.500', 'name' => 'SHU', 'type' => 1],
            ['code' => '3.500.01', 'name' => 'SHU Tahun Berjalan', 'type' => 0],
            ['code' => '3.500.02', 'name' => 'SHU Tahun Lalu', 'type' => 0],

            ["code" => '4.100', "name" => "Pendapatan Bunga", "type" => 1],
            ["code" => '4.100.10', "name" => "Pendapatan Bunga Simpanan", "type" => 0],
            ["code" => '4.100.20', "name" => "Pendapatan Bunga Pinjaman", "type" => 0],

            ["code" => '4.200', "name" => " Pendapatan Administrasi ", "type" => 1],
            ["code" => '4.200.10', "name" => "Pendapatan Biaya Administrasi Anggota", "type" => 0],
            ["code" => '4.200.20', "name" => "Pendapatan Biaya Administrasi Pinjaman", "type" => 0],
            ["code" => '4.200.30', "name" => " Pendapatan Biaya Layanan", "type" => 0],

            ["code" => '4.300', "name" => "Pendapatan Lain-lain ", "type" => 1],
            ["code" => '4.300.10', "name" => "Pendapatan dari Penjualan Aset", "type" => 0],
            ["code" => '4.300.20', "name" => "Pendapatan dari Investasi", "type" => 0],

            ["code" => '4.500', "name" => "Pendapatan Non Operasional ", "type" => 1],
            ["code" => '4.500.10', "name" => "Pendapatan Non Operasional ", "type" => 0],


            ["code" => '5.100', "name" => "Biaya Bunga", "type" => 1],
            ["code" => '5.100.10', "name" => "Biaya Bunga Pinjaman Jangka Pendek", "type" => 0],
            ["code" => '5.100.20', "name" => "Biaya Bunga Pinjaman Jangka Panjang", "type" => 0],

            ["code" => '5.200', "name" => " Biaya Administrasi ", "type" => 1],
            ["code" => '5.200.10', "name" => "Biaya Administrasi Operasional", "type" => 0],
            ["code" => '5.200.20', "name" => "Biaya Administrasi Umum", "type" => 0],


            ["code" => '5.300', "name" => " Biaya Penyusutan ", "type" => 1],
            ["code" => '5.300.10', "name" => "Penyusutan Aset Inventaris Perlengkapan Kantor", "type" => 0],
            ["code" => '5.300.20', "name" => "Penyusutan Kendaraan", "type" => 0],

            ["code" => '5.400', "name" => " Biaya Umum dan Perlengkapan ", "type" => 1],
            ["code" => '5.400.10', "name" => "Biaya Utilitas (Listrik, Air, Telepon)", "type" => 0],
            ["code" => '5.400.20', "name" => "Biaya Perbaikan dan Pemeliharaan", "type" => 0],

            ["code" => '5.410', "name" => "  Biaya Tenaga Kerja", "type" => 1],
            ["code" => '5.410.10', "name" => "Gaji Karyawan Tetap", "type" => 0],
            ["code" => '5.410.20', "name" => "Upah Karyawan Lepas", "type" => 0],


            ["code" => '5.420', "name" => "  Biaya Lain-lain", "type" => 1],
            ["code" => '5.420.10', "name" => " Biaya Transportasi", "type" => 0],
            ["code" => '5.420.20', "name" => " Biaya Pelatihan", "type" => 0],


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
                "credit"      => 500000000,
                "username"  => 'system'
            ], [
                "invoice"     => $invoice,
                "date"        => "2000-01-01",
                "rekening"    => "1.100.20",
                "description" => "Dana Cadangan",
                "debit"       => 500000000,
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
                "code" => 'PJ_01', "name" => "Modal Kerja", "account_loan" => "1.120.10", "account_income_administration" => "4.200.20", "account_income_interest" => "4.100.20",
                "account_dutystamp" => "1.160.10",
            ],
            [
                "code" => 'PJ_02', "name" => "Umum", "account_loan" => "1.120.10", "account_income_administration" => "4.200.20", "account_income_interest" => "4.100.20",
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