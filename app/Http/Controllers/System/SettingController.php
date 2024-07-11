<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\System\Config;
use App\Models\System\Setting;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        log_custom("Buka menu setting");
        abort_if(Gate::denies('setting_read'), 403);
        $data = Template::get();
        array_push($data['pilihCss'],  "apex-charts", "card-analytics");
        $data['setting'] = Setting::first();
        $data['jsTambahan'] = "
        $('#cashier').addClass('active');
        ";
        return view("user.setting", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
    public function update(Request $request, Setting $setting)
    {
        abort_if(Gate::denies('setting_read'), 403);
        $request->validate([
            'company_name' => 'required',
            'company_address' => 'required',
            'company_email' => 'required|email',
            'company_phone' => 'required',
            'company_chairman' => 'required',
            'company_treasurer' => 'required',
            'company_secretary' => 'required',
        ]);

        $setting->update($request->all());
        log_custom("Update config");
        return response()->json("reload", 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
