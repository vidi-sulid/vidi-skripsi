<?php

namespace App\Library;

use App\Models\Business\Business as BusinessBusiness;
use App\Models\Business\BusinessMutation;
use App\Models\DepositMutation;
use App\Models\Master\Member as MasterMember;
use App\Models\Member as ModelsMember;
use App\Models\Transaksi\SavingMutation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Member
{
    static function get($tgl, $member = null)
    {

        $mutation = SavingMutation::select(
            'rekening',
            DB::raw("ifnull(SUM(credit-debit),0) as balance"),
        )
            ->groupBy("rekening")
            ->where("date", "<=", $tgl)
            ->get();

        foreach ($mutation as $key => $value) {
            $memberBalance[$value->rekening] = $value->balance;
        }
        if ($member != null) {
            //$member = $member->toarray();
            foreach ($member as $key => $value) {
                $member[$key]->mandatoryBalance = isset($memberBalance[$value['mandatoryaccount']]) ? $memberBalance[$value['mandatoryaccount']] : 0;
                $member[$key]->principalBalance = isset($memberBalance[$value['principalaccount']]) ? $memberBalance[$value['principalaccount']] : 0;
            }
        } else {
            $member = MasterMember::where("date", "<=", $tgl)->get()->toArray();
            foreach ($member as $key => $value) {
                $member[$key]['mandatoryBalance'] = isset($memberBalance[$value['mandatoryaccount']]) ? $memberBalance[$value['mandatoryaccount']] : 0;
                $member[$key]['principalBalance'] = isset($memberBalance[$value['principalaccount']]) ? $memberBalance[$value['principalaccount']] : 0;
            }
        }

        return $member;
    }
}
