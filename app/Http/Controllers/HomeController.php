<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function show()
    {
        $data = Template::get();
        array_push($data['pilihCss'],  "chart");
        array_push($data['pilihJs'],   "chart");
        $data['jsTambahan'] = "
        $('#dashboards').addClass('open active');
        ";
        return view("home", $data);
    }
}