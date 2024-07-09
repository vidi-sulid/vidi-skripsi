<?php

namespace App\Livewire\Report;

use App\Models\Master\Coa;
use App\Models\Transaksi\Journal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProfitlossReport extends Component
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

        $account = Coa::where("code", ">=", "4")->get()->toArray();
        $dataSaldoAwal = Journal::select(DB::raw("sum(debit) debit, sum(credit) credit, rekening"))
            ->where("date", "<=", $tglLalu)->groupBy("rekening")->get()->toArray();

        $dataTransaksi = Journal::select(DB::raw("sum(debit) debit, sum(credit) credit, rekening"))
            ->whereBetween("date", [$this->date_start, $this->date_end])->groupBy("rekening")->get()->toArray();

        $pendapatanNonOpAwal = getConfig("msRekeningNonOpAwal", "4.500");
        $pendapatanNonOpAkhir = getConfig("msRekeningNonOpAkhir", "4.999");

        $vaLabaNonOp = [];
        $biayaNonOpAwal = getConfig("msRekeningNonOpAwal", "5.500");
        $biayaNonOpAkhir = getConfig("msRekeningNonOpAkhir", "5.999");
        foreach ($account as $value1) {
            $vaLaba[$value1['code']] = [
                "type" => $value1['type'],
                "keterangan" => $value1['name'],
                "saldoawal" => 0,
                "debit" => 0,
                "credit" => 0,
                "saldoakhir" => 0
            ];

            foreach ($dataSaldoAwal as $value2) {
                if (strpos($value2['rekening'], $value1['code']) === 0) {
                    $key = substr($value2['rekening'], 0, 1);
                    $vaLaba[$value1['code']]['saldoawal'] += ($key == "5") ? $value2['debit'] - $value2['credit'] : $value2['credit'] - $value2['debit'];
                    $vaLaba[$value1['code']]['saldoakhir'] += ($key == "5") ? $value2['debit'] - $value2['credit'] : $value2['credit'] - $value2['debit'];
                }
            }
            foreach ($dataTransaksi as $value2) {
                if (strpos($value2['rekening'], $value1['code']) === 0) {
                    $key = substr($value2['rekening'], 0, 1);
                    $vaLaba[$value1['code']]['debit'] += $value2['debit'];
                    $vaLaba[$value1['code']]['credit'] += $value2['credit'];
                    $vaLaba[$value1['code']]['saldoakhir'] = ($key == "5") ?
                        $vaLaba[$value1['code']]['saldoawal'] + $vaLaba[$value1['code']]['debit'] - $vaLaba[$value1['code']]['credit'] :
                        $vaLaba[$value1['code']]['saldoawal'] + $vaLaba[$value1['code']]['credit'] - $vaLaba[$value1['code']]['debit'];
                }
            }
        }
        foreach ($vaLaba as $key => $value) {
            $nominal = $value['saldoawal'] + $value['debit'] + $value['credit'];
            if (!$nominal != 0) {
                unset($vaLaba[$key]);
            } else {
                if ($key >= $pendapatanNonOpAwal && $key <= $pendapatanNonOpAkhir || $key >= $biayaNonOpAwal && $key <= $biayaNonOpAkhir) {
                    $vaLabaNonOp[$key] = $value;
                    unset($vaLaba[$key]);
                }
            }
        }
        $data['data'] = array("labaOP" => $vaLaba, "labaNonOP" => $vaLabaNonOp);

        session()->put('profitloss', $data);
        $judul = tanggalIndonesia($this->date_start) . " s/d " . tanggalIndonesia($this->date_end);
        session()->put('judulProfitloss', $judul);
        return view('livewire.report.profitloss-report', $data);
    }
}
