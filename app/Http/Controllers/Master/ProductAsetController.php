<?php

namespace App\Http\Controllers\Master;

use App\DataTables\ProductAsetDataTable;
use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Master\ProductAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductAsetDataTable $dataTable)
    {
        abort_if(Gate::denies('productaset_read'), 403);
        log_custom("Buka menu master golongan aset");
        $data = Template::get("datatable");
        $data['jsTambahan'] = "
        $('#product-aset').addClass('active');
        ";
        return $dataTable->render("master/aset_product", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('productaset_write'), 403);
        log_custom("Buka menu tambah golongan aset");
        return view('master.aset_product_create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('productaset_write'), 403);
        $request->validate([
            'name' => 'required|string|max:255',
            'account_cost' => 'required|',
            'account_income' => 'required|',
            'account_depreciation' => 'required|',
            'account_aset' => 'required|',
        ]);

        $data = $request->all();
        $max_id = ProductAset::max('id');
        $data['code'] = 'AS_' . str_pad($max_id ? $max_id + 1 : 1, 2, '0', STR_PAD_LEFT);
        log_custom("Insert data master aset", $data);
        ProductAset::create($data);
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
    public function edit(ProductAset $productAset)
    {
        abort_if(Gate::denies('productaset_update'), 403);
        log_custom("Buka menu edit master golongan aset " . $productAset->id);
        $data['data'] = $productAset;
        return view('master.aset_product_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductAset $productAset)
    {
        abort_if(Gate::denies('productaset_update'), 403);

        $request->validate([
            'name' => 'required|string|max:255',
            'account_cost' => 'required|',
            'account_income' => 'required|',
            'account_depreciation' => 'required|',
            'account_aset' => 'required|',
        ]);
        $data = $request->all();

        $productAset->update($data);
        log_custom("Update data golongan aset " . $productAset->id, $productAset->toArray());


        return response()->json($productAset, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductAset $productAset)
    {
        abort_if(Gate::denies('productaset_delete'), 403);
        $productAset->delete();
        log_custom("Hapus data " . $productAset->id, $productAset->toArray());
        return response()->json("ok");
    }
}
