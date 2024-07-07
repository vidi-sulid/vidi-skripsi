<?php

namespace App\Livewire\Transaksi;

use App\Library\Member;
use App\Models\Transaksi\Loan;
use Livewire\Component;

class Cashier extends Component
{
    public $listeners = ['rekeningSelected', 'discountModalRefresh'];
    public $rekening;
    public $nama;
    public $invoice;
    public $type;
    public $data;
    public function render()
    {
        return view('livewire.transaksi.cashier');
    }
    public function rekeningSelected($member)
    {
        $this->rekening = $member['rekening'];
        $this->nama = $member['name'];
        $this->type = $member['type'];
        if ($member['type'] == "loan") {
            $loan = Loan::where("rekening", $this->rekening)->get();
            $this->data = Member::loan(getTgl(), $loan);
            $this->invoice = invoice("AGP");
        }
    }
}