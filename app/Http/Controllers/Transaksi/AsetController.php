<?php

namespace App\Http\Controllers\Transaksi;

use App\DataTables\AsetDataTable;
use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Transaksi\Aset;
use App\Models\Transaksi\AsetMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AsetDataTable $dataTable)
    {
        abort_if(Gate::denies('aset_read'), 403);
        log_custom("Buka menu transaksi pembelian aset");
        $data = Template::get("datatable");
        $data['jsTambahan'] = "
        $('#aset').addClass('active');
        $('#transaksi').addClass('open active');
        ";
        return $dataTable->render("transaksi/aset", $data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('aset_write'), 403);
        log_custom("Buka menu tambah pembelian aset");
        return view('transaksi.aset_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('aset_write'), 403);

        $request->merge(['price' => convertRupiahToNumber($request->price), 'residual_value' => convertRupiahToNumber($request->residual_value)]);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'depreciation_period' => 'required|numeric|min:0.01'
        ]);

        $data = $request->all();
        $max_id = Aset::max('id');
        $data['purchase_date'] = date("Y-m-d");
        $data['username'] = Auth::user()->name;
        $data['code'] = str_pad($max_id ? $max_id + 1 : 1, 6, '0', STR_PAD_LEFT);
        log_custom("Insert data master aset", $data);
        Aset::create($data);

        $invoice = invoice("AS", true);
        $vaMutasi = array(
            "invoice" => $invoice,
            "asset_id" => $data['code'],
            "date" => $data['purchase_date'],
            "username" => $data['username'],
            "description" => "sdf",
            "debit_price" => $data['price'],
            "debit_book_value" => $data['price']
        );
        AsetMutation::create($vaMutasi);
        UpdAset($invoice);
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
