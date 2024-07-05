<?php

namespace App\Livewire\Report;

use App\Models\Transaksi\Journal;
use Livewire\Component;
use Livewire\WithPagination;

class JournalReport extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $username;
    public $date_start;
    public $date_end;

    protected $rules = [
        'periode'   => 'required|',
    ];

    public function mount($username)
    {
        $this->username = $username;
        $this->date_start = date("Y-m-d");
        $this->date_end = date("Y-m-d");
    }

    public function render()
    {
        $journal = Journal::with(['coa'])->whereBetween('date', [$this->date_start, $this->date_end])

            ->orderBy('id', 'desc')->paginate(100);


        return view('livewire.report.journal-report', [
            'journal' => $journal
        ]);
    }

    public function generateReport()
    {
        $this->validate();
        $this->render();
    }
}
