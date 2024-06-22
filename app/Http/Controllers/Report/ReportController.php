<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    public function asetReport()
    {
        abort_if(Gate::denies('reports_read'), 403);
        $data = Template::get();
        $data['jsTambahan'] = "
        $('#aset-report').addClass('active');
        $('#report').addClass('open active');
        ";
        return view('report.aset', $data);
    }

    public function journalReport()
    {
        abort_if(Gate::denies('journal_read'), 403);
        $data = Template::get();
        $data['jsTambahan'] = "
        $('#journal-report').addClass('active');
        $('#report').addClass('open active');
        ";
        return view('report.journal', $data);
    }
}
