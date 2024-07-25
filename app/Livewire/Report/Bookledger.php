<?php

namespace App\Livewire\Report;

use App\Models\Transaksi\Journal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


class Bookledger extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $coa;
    public $date_start;
    public $date_end;
    public $rekening;

    protected $rules = [
        "date_start" => "required"
    ];

    public function mount($coa)
    {
        $this->coa = $coa;
        $this->date_start = date("Y-m-d");
        $this->date_end = date("Y-m-d");
    }
    public function render()
    {


        $tglLalu = Carbon::parse($this->date_start)->subDay()->toDateString();
        $saldolalu = Journal::select(DB::raw("
        CASE 
            WHEN substr(rekening, 1, 1) = '1' or substr(rekening, 1, 1) = '5' THEN ifnull(sum(debit - credit),0) 
            ELSE ifnull(sum(credit - debit),0) 
        END as total
    "))->where("date", "<=", $tglLalu)->where("rekening", $this->rekening)->groupBy("rekening")->first();
        $saldo = 0;
        if ($saldolalu) {
            $saldo = $saldolalu->total;
        }
        $journal = Journal::with(['coa'])->where("rekening", $this->rekening)->whereBetween('date', [$this->date_start, $this->date_end])
            ->orderBy('date', 'asc')->orderBy("id", "asc")->paginate(100);
        session()->put('bookledger', $journal);
        $judul = tanggalIndonesia($this->date_start) . " s/d " . tanggalIndonesia($this->date_end);
        session()->put('judulBookledger', $judul);
        session()->put('saldoBookledger', $saldo);
        return view('livewire.report.bookledger', [
            'journal' => $journal,
            'saldo'   => $saldo
        ]);
    }

    public function generateReport()
    {

        $this->dispatch('refresh', 1);

        $this->validate();
        $this->render();
    }
}