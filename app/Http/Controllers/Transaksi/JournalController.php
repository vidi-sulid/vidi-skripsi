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
        $data = $request->all();
        foreach ($data['mutation'] as $value) {
            DB::table($value)->where("invoice", $id)->delete();
        }
        log_custom("Delete Mutasi Faktur $id", $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
