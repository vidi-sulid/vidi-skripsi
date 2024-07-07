<?php

namespace App\Livewire\Report;

use App\Library\Member;
use App\Models\Transaksi\Loan;
use Livewire\Component;

class LoanReport extends Component
{
    public $date;
    public $member;
    protected $rules = [
        'date'   => 'required|',
    ];
    public function mount()
    {
        $this->date = date("Y-m-d");
    }

    public function render()
    {
        $loan = Loan::with(['member'])->where('date_open', "<=", $this->date)

            ->orderBy('date_open', 'desc')->paginate(100);
        $data['loan'] = Member::loan($this->date, $loan);

        return view('livewire.report.loan-report', $data);
    }
    public function generateReport()
    {
        $this->validate();
        $this->render();
    }
}