<?php

namespace Database\Seeders;

use App\Models\Master\Member;
use App\Models\Master\Saving;
use App\Models\Transaksi\SavingMutation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Member::factory()->count(100)->create();
        $mutasi = Member::get();
        foreach ($mutasi as $data) {
            $data['MandatoryAccount'] = implode('.', ["01", "SP_01", $data['code']]);
            $vaRekening = [
                "rekening" => $data['MandatoryAccount'],
                "date_open" => date("Y-m-d"),
                "product_saving_id" => "SP_01",
                "member_code" => $data['code'],
                "username" => "system"
            ];
            Saving::create($vaRekening);
            $data['MandatoryAccount1'] = implode('.', ["01", "SP_02", $data['code']]);
            $vaRekening = [
                "rekening" => $data['MandatoryAccount1'],
                "date_open" => date("Y-m-d"),
                "product_saving_id" => "SP_02",
                "member_code" => $data['code'],
                "username" => "system"
            ];
            Saving::create($vaRekening);

            $invoice = invoice("SPA", true);
            $mutation = [
                "invoice"         => $invoice,
                "date"            => $data['date'],
                "rekening"        => $data['MandatoryAccount'],
                "codetransaction" => '01',
                "description"     => "Setoran Awal Anggota an. " . $data['name'],
                "debit"           => 0,
                "credit"          => 100000,
                "username"        => "system",
                "cash"            => 'K'
            ];
            SavingMutation::create($mutation);

            // //Update Transaction Mandatory Account
            $mutation['rekening'] = $data['MandatoryAccount1'];
            $mutation['credit']   = 100000;
            SavingMutation::create($mutation);

            UpdateJournalSaving($invoice);
        }
    }
}
