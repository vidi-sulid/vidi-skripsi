<?php

namespace App\Library;

use App\Models\Business\Business as BusinessBusiness;
use App\Models\Business\BusinessMutation;
use App\Models\DepositMutation;
use App\Models\Master\Member as MasterMember;
use App\Models\Member as ModelsMember;
use App\Models\Transaksi\LoanMutation;
use App\Models\Transaksi\SavingMutation;
use Carbon\Carbon;
use DateInterval;
use DateTime;
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

    static function loan($tgl, $loan = null)
    {
        foreach ($loan as $key => $value) {
            $loan[$key]->ke = min(differenceDay($value->date_open, $tgl, true), $value->loan_term);
            $loan[$key]->jthtmp = nextMonth($value->date_open, $value->loan_term);
            $loan[$key]->schedule = self::schedule($loan[$key]);
            $loan[$key]->kewajibanPokok = 0;
            $loan[$key]->kewajibanBunga = 0;
            foreach ($loan[$key]->schedule as $valueJadwal) {
                $loan[$key]->kewajibanPokok += $valueJadwal['kewajibanPokok'];
                $loan[$key]->kewajibanBunga += $valueJadwal['kewajibanBunga'];
            }

            $loan[$key]->pembayaran = self::getPembayaran($value->rekening, $tgl);
            $loan[$key]->bakidebet = self::bakidebet($value->rekening, $tgl);
            $loan[$key]->tunggakanPokok = max(0, $loan[$key]->kewajibanPokok - $loan[$key]->pembayaran->pokok);
            $loan[$key]->tunggakanBunga = max(0, $loan[$key]->kewajibanBunga - $loan[$key]->pembayaran->bunga);
        }
        return $loan;
    }
    static function schedule($loan)
    {

        $vaSchedule = [];
        for ($start = 1; $start <= $loan->ke; $start++) {

            $jthtmp = nextMonth($loan->date_open, $start, true);
            $pokok = round($loan->loan_amount / $loan->loan_term);
            $bunga = round($loan->loan_amount / $loan->interest_rate / 100 / 12);
            $vaSchedule[$jthtmp] = array("ke" => $start, "kewajibanPokok" => $pokok, "kewajibanBunga" => $bunga);
        }
        return $vaSchedule;
    }

    static function getPembayaran($rekening, $tgl)
    {
        $mutation = LoanMutation::where("rekening", $rekening)->where("date", "<=", $tgl)->where('status', 1)
            ->selectRaw('ifnull(SUM(debit - credit),0) as pokok ,ifnull(SUM(debit_interest - credit_interest),0) as bunga')
            ->first();
        return $mutation;
    }
    static function bakidebet($rekening, $tgl)
    {
        $mutation = LoanMutation::where("rekening", $rekening)->where("date", "<=", $tgl)
            ->selectRaw('ifnull(SUM(debit - credit),0) as bakidebet')
            ->first();
        return $mutation->bakidebet;
    }
}