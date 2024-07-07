<?php

namespace App\Livewire\Transaksi;

use Livewire\Component;

class Loan extends Component
{
    public  $customer;
    public $content;
    public $codeCustomer;
    public $tes;
    public $codeGolongan;
    public $rekening;

    protected $listeners = ['loadDynamicContent'];

    public function mount($customer)
    {
        $this->customer = $customer;
    }
    public function render()
    {
        return view('livewire.transaksi.loan');
    }

    public function updateGolongan($value)
    {
        $this->codeGolongan = $value;
        $this->generateRekening();
    }
    public function generateRekening($value = '')
    {
        if ($value != '') {
            $this->codeCustomer = str_pad($value, "7", "0", STR_PAD_LEFT);
        }
        $this->rekening = getRekeningLoan($this->codeCustomer, $this->codeGolongan);
    }
    public function update()
    {
        print_r(22);
    }
}
