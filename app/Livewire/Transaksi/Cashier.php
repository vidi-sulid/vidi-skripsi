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
        } else if ($this->type == "saving") {
            $this->data = Saving::with(['product'])->where("rekening", $this->rekening)->first();
            $this->invoice = invoice("STA");
            $this->data->saldo = Member::saldoSimpanan($this->rekening, getTgl());
            $this->mutation = SavingMutation::where("rekening", $this->rekening)->where("date", "<=", getTgl())->get();
            $this->keterangan = " an " . $this->nama;
        }
    }

    public function resetComponent()
    {
        // Lakukan logika reset state atau data komponen di sini
        $this->reset(); // Contoh: Mereset semua properti state komponen

        // Jika perlu melakukan operasi tambahan setelah reset
        $this->emit('componentReset'); // Emit event untuk memberi tahu JavaScript bahwa reset selesai
    }
    public function eventName()
    {
        $this->reset();
    }
    function updated()
    {
        $this->emit('rekeningSelected');
    }

    public function initializePlugin()
    {
        $this->dispatchBrowserEvent('initializePlugin');
    }
}
