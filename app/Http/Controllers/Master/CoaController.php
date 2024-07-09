<?php

namespace App\Http\Controllers\Master;

use App\DataTables\CoaDataTable;
use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Master\Coa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class CoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CoaDataTable $dataTable)
    {
        abort_if(Gate::denies('coa_read'), 403);
        log_custom("Buka menu master coa");
        $data = Template::get("datatable");
        $data['jsTambahan'] = "
        $('#coa').addClass('active');
        ";
        return $dataTable->render("master/coa", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('coa_write'), 403);
        log_custom("Buka menu tambah master coa");
        return view('master.coa_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('coa_write'), 403);
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'max:8',
                function ($attribute, $value, $fail) {
                    // Periksa panjang kode
                    $length = strlen($value);

                    // Jika panjang kode bukan 1, 5, atau 8, maka tolak validasi
                    if ($length !== 1 && $length !== 5 && $length !== 8) {
                        $fail("Panjang $attribute harus 1, 5, atau 8 karakter.");
                    }

                    // Cek apakah kode unik dalam tabel coas
                    if (Coa::where('code', $value)->exists()) {
                        $fail("Nilai $attribute sudah digunakan.");
                    }
                },
            ],
        ]);

        $data = $request->all();

        log_custom("Insert data master coa", $data);
        Coa::create($data);
        return response()->json("ok");
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
    public function edit(Coa $coa)
    {
        abort_if(Gate::denies('coa_update'), 403);
        log_custom("Buka menu edit msater coa " . $coa->id);
        $data['coa'] = $coa;
        return view('master.coa_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coa $coa)
    {
        abort_if(Gate::denies('coa_update'), 403);
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'max:8',
                Rule::unique('coas')->ignore($coa->id),
            ],
        ]);

        log_custom("Update data master coa " . $coa->id, $coa->toArray());
        $coa->update($request->all());

        return response()->json($coa, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coa $coa)
    {
        abort_if(Gate::denies('coa_delete'), 403);
        $coa->delete();
        log_custom("Hapus data " . $coa->id, $coa->toArray());
        return response()->json("ok");
    }
}
