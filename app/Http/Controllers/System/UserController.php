<?php

namespace App\Http\Controllers\System;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        abort_if(Gate::denies('user_read'), 403);
        log_custom("Buka menu master user");
        $data = Template::get("datatable");
        $data['jsTambahan'] = "
        $('#user').addClass('active');
        $('#role-permission').addClass('open active');
        ";
        return $dataTable->render("user/user", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        abort_if(Gate::denies('user_write'), 403);
        log_custom("Buka menu tambah master user");
        return view('user.user_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        abort_if(Gate::denies('user_write'), 403);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'role' => 'required',
            'rekening_kas' => 'required',
            'rekening_volt_id' => 'required',
        ]);
        $data = $request->all();
        log_custom("Simpan menu master user", $data);
        $data['password'] = Hash::make('123456789');
        $user = User::create($data);
        $role = Role::whereId($request->role)->first();
        $user->assignRole($role);

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
    public function edit(string $id)
    {
        abort_if(Gate::denies('user_update'), 403);
        log_custom("Edit menu master user $id");
        $data['user'] = User::whereId($id)->first();
        return view('user.user_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('user_update'), 403);
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],

            'rekening_kas' => 'required',
            'rekening_volt_id' => 'required',
            'role' => 'required'
        ]);
        $data = $request->all();
        log_custom("Update data master user", $data);
        $reset = $data['reset'];
        if ($reset == "1") {
            $data['password'] = Hash::make('111');
        }
        unset($data['_token'], $data['role'], $data['reset']); //, 
        User::whereId($id)->update($data);

        $role = Role::whereId($request->role)->first();
        $user = User::find($id);
        $user->assignRole($role);

        log_custom("Simpan User", $data);
        return response()->json("ok");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        abort_if(Gate::denies('user_delete'), 403);
        log_custom("Hapus data master user $id");
        $user = User::find($id);
        if ($user) {
            $user->roles()->detach();
            $user->delete();
        }
        return response()->json("ok");
    }
}
