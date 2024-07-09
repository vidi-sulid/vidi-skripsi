<?php

namespace App\Http\Controllers\Master;

use App\DataTables\ProductSavingDataTable;
use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Master\ProductSaving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProductSavingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductSavingDataTable $dataTable)
    {
        abort_if(Gate::denies('productsaving_read'), 403);
        log_custom("Buka menu master simpanan");
        $data = Template::get("datatable");
        $data['jsTambahan'] = "
        $('#product-saving').addClass('active');
        $('#master-member').addClass('open active');
        ";
        return $dataTable->render("master.saving_product", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('productsaving_write'), 403);
        log_custom("Buka menu tambah master simpanan");
        return view('master.saving_product_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('productaset_write'), 403);
        $request->merge(['principal_deposit' => convertRupiahToNumber($request->principal_deposit), 'mandatory_deposit' => convertRupiahToNumber($request->mandatory_deposit)]);
        $request->validate([
            'name' => 'required|string|max:255',
            'account_saving' => 'required|',
            'account_income_administration' => 'required|',
            'account_cost' => 'required|',
        ]);

        $data = $request->all();
        $max_id = ProductSaving::max('id');
        $data['code'] = 'SP_' . str_pad($max_id ? $max_id + 1 : 1, 2, '0', STR_PAD_LEFT);
        log_custom("Insert data master aset", $data);
        ProductSaving::create($data);
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
    public function edit(ProductSaving $productSaving)
    {
        abort_if(Gate::denies('productsaving_update'), 403);
        log_custom("Buka menu edit master simpanan " . $productSaving->id);
        $data['productSaving'] = $productSaving;
        return view('master.saving_product_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductSaving $productSaving)
    {
        abort_if(Gate::denies('productsavnig_update'), 403);
        $request->merge(['principal_deposit' => convertRupiahToNumber($request->principal_deposit), 'mandatory_deposit' => convertRupiahToNumber($request->mandatory_deposit)]);

        $request->validate([
            'name' => 'required|string|max:255',
            'account_saving' => 'required|',
            'account_income_administration' => 'required|',
            'account_cost' => 'required|',
        ]);

        log_custom("Update data master simpanan " . $productSaving->code, $productSaving->toArray());
        $productSaving->update($request->all());

        return response()->json($productSaving, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSaving $productSaving)
    {
        abort_if(Gate::denies('productsaving_delete'), 403);
        $productSaving->delete();
        log_custom("Hapus data " . $productSaving->id, $productSaving->toArray());
        return response()->json("ok");
    }
}
