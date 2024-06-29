<?php

namespace App\Http\Controllers\Master;

use App\DataTables\ProductLoanDataTable;
use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Master\ProductLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductLoanController extends Controller
{
    public function index(ProductLoanDataTable $dataTable)
    {
        abort_if(Gate::denies('productloan_read'), 403);
        log_custom("Buka menu master pinjaman");
        $data = Template::get("datatable");
        $data['jsTambahan'] = "
        $('#loan-master').addClass('active');
        $('#master').addClass('open active');
        ";
        return $dataTable->render("master.loan_product", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('productloan_write'), 403);
        log_custom("Buka menu tambah master pinjaman");
        return view('master.loan_product_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('productloan_write'), 403);
        $request->validate([
            'name' => 'required|string|max:255',
            'account_loan' => 'required|',
            'account_income_administration' => 'required|',
            'account_income_interest' => 'required|',
            'account_dutystamp' => 'required|',
        ]);

        $data = $request->all();
        $max_id = ProductLoan::max('id');
        $data['code'] = 'PJ_' . str_pad($max_id ? $max_id + 1 : 1, 2, '0', STR_PAD_LEFT);
        log_custom("Insert data master pinjaman", $data);
        ProductLoan::create($data);
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
    public function edit(ProductLoan $productLoan)
    {
        abort_if(Gate::denies('productloan_update'), 403);
        log_custom("Buka menu edit master pinjaman " . $productLoan->id);
        $data['productLoan'] = $productLoan;
        return view('master.loan_product_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductLoan $productLoan)
    {
        abort_if(Gate::denies('productloan_update'), 403);
        $request->validate([
            'name' => 'required|string|max:255',
            'account_loan' => 'required|',
            'account_income_administration' => 'required|',
            'account_income_interest' => 'required|',
            'account_dutystamp' => 'required|',
        ]);

        log_custom("Update data master pinjaman " . $productLoan->code, $productLoan->toArray());
        $productLoan->update($request->all());

        return response()->json($productLoan, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductLoan $productLoan)
    {
        abort_if(Gate::denies('productloan_delete'), 403);
        $productLoan->delete();
        log_custom("Hapus data " . $productLoan->id, $productLoan->toArray());
        return response()->json("ok");
    }
}
