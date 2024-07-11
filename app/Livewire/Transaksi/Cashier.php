<?php

namespace App\Livewire\Transaksi;

use App\Library\Member;
use App\Models\Master\Saving;
use App\Models\Transaksi\Loan;
use App\Models\Transaksi\LoanMutation;
use App\Models\Transaksi\SavingMutation;
use Livewire\Component;

class Cashier extends Component
{

    public $listeners = ['rekeningSelected', 'discountModalRefresh'];
    public $rekening;
    public $nama;
    public $invoice;
    public $type;
    public $data;
    public $keterangan;
    public $mutation = array();
    public $loan_amount;
    public $bakidebet;
    public $tunggakanPokok;
    public $tunggakanBunga;
    public $setoranWajib;
    public $setoranPokok;
    public $saldo;

    public function boot()
    {
        //
    }
    public function mount()
    {
        $this->reset();
    }
    public function render()
    {
        return view('livewire.transaksi.cashier');
    }
    public function rekeningSelected($member)
    {
        $this->eventName("eventName", "dfs");
        $this->rekening = $member['rekening'];
        $this->nama = $member['name'];
        $this->type = $member['type'];
        if ($member['type'] == "loan") {
            $loan = Loan::where("rekening", $this->rekening)->get();
            $this->data = Member::loan(getTgl(), $loan);
            $this->invoice = invoice("AGP");
            $this->mutation = LoanMutation::where("rekening", $this->rekening)->where("date", "<=", getTgl())->get();
            $this->keterangan = "Pembayaran angsuran pinjaman an " . $this->data[0]->member->name;
            $this->loan_amount = number_format($this->data[0]->loan_amount);
            $this->bakidebet = number_format($this->data[0]->bakidebet);
            $this->tunggakanBunga = number_format($this->data[0]->tunggakanBunga);
            $this->tunggakanPokok = number_format($this->data[0]->tunggakanPokok);
        } else if ($this->type == "saving") {
            $this->data = Saving::with(['product'])->where("rekening", $this->rekening)->first();
            $this->invoice = invoice("STA");
            $this->saldo = number_format(Member::saldoSimpanan($this->rekening, getTgl()));
            $this->mutation = SavingMutation::where("rekening", $this->rekening)->where("date", "<=", getTgl())->get();
            $this->setoranWajib = number_format($this->data->product->mandatory_deposit);
            $this->setoranPokok = number_format($this->data->product->principial_deposit);
            $this->keterangan = " an " . $this->nama;
        }
    }

    public function resetComponent()
    {
        // Lakukan logika reset state atau data komponen di sini
        $this->reset(); // Contoh: Mereset semua properti state komponen

    }
    public function eventName()
    {
        $this->reset();
    }


    public function initializePlugin()
    {
        $this->dispatchBrowserEvent('initializePlugin');
    }
}
