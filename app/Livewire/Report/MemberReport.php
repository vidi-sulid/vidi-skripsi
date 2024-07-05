<?php

namespace App\Livewire\Report;

use App\Library\Member;
use App\Models\Master\Member as MasterMember;
use Livewire\Component;

class MemberReport extends Component
{

    public $date;
    protected $rules = [
        'date'   => 'required|',
    ];
    public function mount()
    {

        $this->date = date("Y-m-d");
    }
    public function render()
    {
        $member = MasterMember::where('date', "<=", $this->date)

            ->orderBy('code', 'desc')->paginate(100);

        $data['member'] = Member::get($this->date, $member);

        return view('livewire.report.member-report', $data);
    }

    public function generateReport()
    {
        $this->validate();
        $this->render();
    }
}
