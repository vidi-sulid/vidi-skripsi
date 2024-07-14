<?php

namespace App\Livewire\Report;

use App\Models\Master\Coa;
use App\Models\Transaksi\Journal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BalancesheetReport extends Component
{

    public $date_start;
    public $date_end;

    public function mount()
    {
        $this->date_start = date("Y-m-d");
        $this->date_end = date("Y-m-d");
    }
    public function render()
    {


        $tglLalu = Carbon::parse($this->date_start)->subDay()->toDateString();

        $account = Coa::where("code", "<", "4")->orderBy("code")->get()->toArray();

        $dataSaldoAwal = Journal::select(DB::raw("sum(debit) debit, sum(credit) credit, rekening"))
            ->where("date", "<=", $tglLalu)->groupBy("rekening")->orderby("rekening")->get()->toArray();

        $dataTransaksi = Journal::select(DB::raw("sum(debit) debit, sum(credit) credit, rekening"))
            ->whereBetween("date", [$this->date_start, $this->date_end])->groupBy("rekening")->get()->toArray();

        $labaRugi = Journal::select(DB::raw("ifnull(sum(debit),0) debit, ifnull(sum(credit),0) credit"))
            ->where("rekening", ">=", 4)
            ->where("date", "<=", $tglLalu)->first();
        //  dd($labaRugi);

        $saldowal = $labaRugi->credit - $labaRugi->debit;

        $labaRugi = Journal::select(DB::raw("ifnull(sum(debit),0) debit, ifnull(sum(credit),0) credit"))
            ->where("rekening", ">=", 4)
            ->whereBetween("date", [$this->date_start, $this->date_end])->first();

        $coaLabaRugi = getConfig("msRekeningLaba", "3.500.01");
        foreach ($account as $value1) {
            if ($value1['code'] != $coaLabaRugi) {
                $vaNeraca[$value1['code']] = [
                    "type" => $value1['type'],
                    "keterangan" => $value1['name'],
                    "saldoawal" => 0,
                    "debit" => 0,
                    "credit" => 0,
                    "saldoakhir" => 0
                ];
            } else {
                $vaCode  =  explode('.', $value1['code']);
                $kodeLaba = "";
                foreach ($vaCode as $key => $value) {
                    $kodeLaba .= $value;
                    $result = implode('.', array_slice($vaCode, 0, $key + 1));

                    if (isset($vaNeraca[$result])) {
                        $vaNeraca[$result]['saldoawal'] += $saldowal;
                        $vaNeraca[$result]['debit'] += $labaRugi->debit;
                        $vaNeraca[$result]['credit'] += $labaRugi->credit;
                        $vaNeraca[$result]['saldoakhir'] +=  $saldowal - $labaRugi->debit + $labaRugi->credit;
                    }
                }
                $vaNeraca[$value1['code']] = [
                    "type" => $value1['type'],
                    "keterangan" => $value1['name'],
                    "saldoawal" => $saldowal,
                    "debit" => $labaRugi->debit,
                    "credit" => $labaRugi->credit,
                    "saldoakhir" => $saldowal - $labaRugi->debit + $labaRugi->credit
                ];
            }
            foreach ($dataSaldoAwal as $value2) {

                if (strpos($value2['rekening'], $value1['code']) === 0) {
                    $key = substr($value2['rekening'], 0, 1);

                    $vaNeraca[$value1['code']]['saldoawal'] += ($key == "1") ? $value2['debit'] - $value2['credit'] : $value2['credit'] - $value2['debit'];
                    $vaNeraca[$value1['code']]['saldoakhir'] += ($key == "1") ? $value2['debit'] - $value2['credit'] : $value2['credit'] - $value2['debit'];
                }
            }
            foreach ($dataTransaksi as $value2) {
                if (strpos($value2['rekening'], $value1['code']) === 0) {
                    $key = substr($value2['rekening'], 0, 1);
                    $vaNeraca[$value1['code']]['debit'] += $value2['debit'];
                    $vaNeraca[$value1['code']]['credit'] += $value2['credit'];
                    $vaNeraca[$value1['code']]['saldoakhir'] = ($key == "1") ?
                        $vaNeraca[$value1['code']]['saldoawal'] + $vaNeraca[$value1['code']]['debit'] - $vaNeraca[$value1['code']]['credit'] :
                        $vaNeraca[$value1['code']]['saldoawal'] + $vaNeraca[$value1['code']]['credit'] - $vaNeraca[$value1['code']]['debit'];
                }
            }
        }

        ksort($vaNeraca);
        foreach ($vaNeraca as $key => $value) {
            $nominal = $value['saldoawal'] + $value['debit'] + $value['credit'];
            if (!$nominal != 0) {
                unset($vaNeraca[$key]);
            }
        }
        $data['data'] = $vaNeraca;
        session()->put('balancesheet', $vaNeraca);
        $judul = tanggalIndonesia($this->date_start) . " s/d " . tanggalIndonesia($this->date_end);
        session()->put('judulBalancesheet', $judul);
        $data['tanggalAwal'] = $this->date_start;
        $data['tanggalAkhir'] = $this->date_end;


        return view('livewire.report.balancesheet-report', $data);
    }
}
