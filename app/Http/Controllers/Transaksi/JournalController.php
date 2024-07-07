<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Transaksi\Journal;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $('#pembukuan').addClass('active');
        $('#transaksi').addClass('open active');
        ";
        Session::forget('cart_items');

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
            if ($value['jenis'] == "pemasukan") {
                $kredit = convertRupiahToNumber($value['nominal']);
            } else {
                $debit = convertRupiahToNumber($value['nominal']);
            }
            $mutation = [
                "invoice"     => $invoice,
                "date"        => date("Y-m-d"),
                "rekening"    => $value['id'],
                "description" => $value['keterangan'],
                "debit"       => $debit,
                "credit"      => $kredit,
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}