<?php

namespace App\Http\Controllers\Transaksi;

use App\DataTables\JournalDataTable;
use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Transaksi\Journal;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, JournalDataTable $dataTable)
    {
        $data = Template::get("datatable");
        $data['startDate'] = $request->dateStart ? $request->dateStart : date('Y-m-d');
        $data['endDate'] = $request->dateEnd ? $request->dateEnd : date('Y-m-d');
        return $dataTable->render('report.journal_delete', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('journal_write'), 403);
        log_custom("Buka menu tambah pemindahbukuan");

        $data = Template::get("datatable");
        $data['jsTambahan'] = "
        $('#akuntansi-transaksi').addClass('open active');
        $('#journal-create').addClass('active');
        ";
        Session::forget('data_jurnal');

        return view('transaksi.journal_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        abort_if(Gate::denies('journal_write'), 403);
        $invoice = invoice("KK", true);
        $data = session()->get('cart_items', []);
        foreach ($data as $key => $value) {
            $kredit = $debit = 0;

            $mutation = [
                "invoice"     => $invoice,
                "date"        => date("Y-m-d"),
                "rekening"    => $value['id'],
                "description" => $value['keterangan'],
                "debit"       => $value['debit'],
                "credit"      => $value['kredit'],
                "username"  => Auth::user()->name
            ];
            Journal::create($mutation);
            if ($mutation['debit'] > 0) {
                $mutation['credit'] = $mutation['debit'];
                unset($mutation['debit']);
            } else {
                $mutation['debit'] = $mutation['credit'];
                unset($mutation['credit']);
            }
            $mutation['rekening'] = Auth::user()->rekening_kas;
            Journal::create($mutation);
        }

        log_custom("Simpan menu tambah transaksi kas", $data);

        return redirect()->route('journal-report');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('journal_delete'), 403);
        log_custom("Buka Menu Detail Hapus Transaksi Faktur $id");
        $vaCheck = [];
        $vaMutation = [
            "Mutasi Simpanan" => "saving_mutations", "Jurnal" => "journals", "Mutasi Aset" => "aset_mutations",
        ];
        foreach ($vaMutation as $key => $value) {
            $lCek = getDataTable("invoice", $value, "", "invoice = '$id'");
            if ($lCek) {
                $vaCheck[$key] = $value;
            }
        }
        $data['invoice'] = $id;
        $data['data'] = $vaCheck;
        return view('report.journal_delete_data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('journal_delete'), 403);
        $request->validate([
            'mutation' => 'required|array',
        ]);
        $tgl = getName($id, "journal", "date", "invoice");
        if ($tgl != getTgl()) {
            return response()->json([
                'info' => 'The code field is required.',
                'errors' => [
                    'error' => ['Data sudah tidak bisa dihapus.']
                ]
            ], 422);
        }
        $data = $request->all();
        foreach ($data['mutation'] as $value) {
            DB::table($value)->where("invoice", $id)->delete();
        }
        log_custom("Delete Mutasi Faktur $id", $data);
        Alert::info("Info", "Data berhasil dihapus");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function close()
    {

        abort_if(Gate::denies('journalclose_write'), 403);
        log_custom("Buka menu penutupan jurnal");
        $data = Template::get();
        $data['jsTambahan'] = "
        $('#akuntansi-transaksi').addClass('open active');
        $('#journalclosing-create').addClass('active');
        ";

        return view('transaksi.journal_close', $data);
        // return $dataTable->render('user.userdate', $data);
    }
    public function closed(Request $request)
    {

        abort_if(Gate::denies('journalclose_write'), 403);
        $request->validate([
            'periode' => 'required'
        ]);
        $data = $request->all();


        $tgl = date("Y-12-t", strtotime($data['periode']));
        $invoice = "PENUTUPAN-" . $request->periode;
        Journal::where("invoice", $invoice)->delete();

        $laba = 0;
        $dataSaldoAwal = Journal::select(DB::raw("sum(credit-debit) total, rekening"))
            ->where("date", "<=", $tgl)->where("rekening", "like", "4%")->groupBy("rekening")->get()->toArray();
        foreach ($dataSaldoAwal as $value) {
            $kredit = $debit = 0;

            if ($value['total'] > 0) {
                $debit = $value['total'];
            } else {
                $kredit = $value['total'];
            }
            $laba += $value['total'];
            $mutation[] = [
                "invoice"     => $invoice,
                "date"        => getTgl(),
                "rekening"    => $value['rekening'],
                "description" => "Penutupan Jurnal 2024",

                "debit"       => $debit,
                "credit"      => $kredit,
                "username"  => Auth::user()->name
            ];
        }
        $dataSaldoAwal = Journal::select(DB::raw("sum(debit-credit) total, rekening"))
            ->where("date", "<=", $tgl)->where("rekening", "like", "5%")->groupBy("rekening")->get()->toArray();
        foreach ($dataSaldoAwal as $value) {
            $kredit = $debit = 0;

            if ($value['total'] > 0) {
                $kredit = $value['total'];
            } else {
                $debit = $value['total'];
            }
            $laba -= $value['total'];
            $mutation[] = [
                "invoice"     => $invoice,
                "date"        => getTgl(),
                "rekening"    => $value['rekening'],
                "description" => "Penutupan Jurnal " . $request->periode,

                "debit"       => $debit,
                "credit"      => $kredit,
                "username"  => Auth::user()->name
            ];
        }
        if ($laba != 0) {
            $debit = $kredit = 0;
            if ($laba < 0) {
                $debit = abs($laba);
            } else {
                $kredit = abs($laba);
            }
            $rekening = getConfig("msLabaTahunLalu", "3.500.02");
            $mutation[] = [
                "invoice"     => "PENUTUPAN-2024",
                "date"        => getTgl(),
                "rekening"    => $rekening,
                "description" => "Penutupan Jurnal 2024",

                "debit"       => $debit,
                "credit"      => $kredit,
                "username"  => Auth::user()->name
            ];
        }
        Journal::insert($mutation);
    }
}
