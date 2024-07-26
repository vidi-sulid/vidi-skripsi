<?php

namespace App\Http\Controllers\System;

use App\DataTables\RolePermissionDataTable;
use App\Http\Controllers\Controller;
use App\Library\Template;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;

use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RolePermissionDataTable $dataTable)
    {

        abort_if(Gate::denies('permission'), 403);
        $data = Template::get("datatable");
        log_custom("Buka menu role permission");
        $data['jsTambahan'] = "
        $('#permission').addClass('active');
        $('#role-permission').addClass('open active');
        ";
        $data['roles'] = Role::all();
        return $dataTable->render("user/permission", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        abort_if(Gate::denies('permission'), 403);
        $data['menu'] = menu();
        log_custom("Buka menu tambah role permission");
        return view('user.permission_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('permission'), 403);
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'permissions' => 'required|array',
        ]);

        $role = Role::create([
            'name' => $request->name
        ]);
        log_custom("Simpan data role permission " . $request->name);
        $role->givePermissionTo($request->permissions);
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

        abort_if(Gate::denies('permission'), 403);
        log_custom("Edit data role permission " . $id);
        $data['menu'] = menu();
        $data['role'] = Role::with(['permissions'])->where("id", $id)->first();
        return view('user.permission_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('permission'), 403);
        $request->validate([
            'name' =>  ['required', Rule::unique('roles')->ignore($id)],
            'permissions' => 'required|array',
        ]);

        $role = Role::whereid($id)->first();
        $role->syncPermissions($request->permissions);
        Role::whereid($id)->update(["name" => $request->name]);
        log_custom("Update menu role permission $id", $role->toArray());

        return response()->json("ok");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('permission'), 403);
        log_custom("Hapus data role permission $id");
        Role::where('id', $id)->delete();
    }
}
