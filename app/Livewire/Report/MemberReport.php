<?php

namespace App\Livewire\Report;

use App\Library\Member;
use App\Models\Master\Member as MasterMember;
use Livewire\Component;

class MemberReport extends Component
{

    public $date;
    public $gender;
    protected $rules = [
        'date'   => 'required|',
    ];
    public function mount()
    {

        $this->date = date("Y-m-d");
    }
    public function render()
    {
        $query = MasterMember::where('date', "<=", $this->date)
            ->where("date_close", ">=", $this->date)

            ->orderBy('code', 'desc');
        if (!empty($this->gender)) {
            $query->where('gender', $this->gender);
        }

        $member = $query->paginate(100);
        $data['member'] = Member::get($this->date, $member);

        return view('livewire.report.member-report', $data);
    }

    public function generateReport()
    {
        $this->validate();
        $this->render();
    }
}
