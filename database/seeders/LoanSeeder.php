<?php

namespace Database\Seeders;

use App\Models\Transaksi\Loan;
use App\Models\Transaksi\LoanMutation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Loan::factory()->count(10)->create();

        $loan = Loan::with(['member'])->get()->toArray();
        foreach ($loan as $data) {
            $mutation = [
                "status"  => 0,
                "invoice"         => $data['invoice'],
                "date"            => date("Y-m-d"),
                "rekening"        => $data['rekening'],
                "description"     => "Pencairan Pinjaman Anggota an. " . $data['member']['name'],
                "credit"           => 0,
                "debit"          => $data['loan_amount'],
                "username"        => 'system',
                "cash"            => 'K'
            ];
            LoanMutation::create($mutation);
            UpdateJournalLoan($data['invoice'], true);
        }
    }
}
