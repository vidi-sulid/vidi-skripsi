<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Transaksi\Loan;
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
        $('#akuntansi-report').addClass('open active');
        ";
        return view('report.journal', $data);
    }

    public function memberReport()
    {
        abort_if(Gate::denies('member_read'), 403);
        $data = Template::get();
        $data['jsTambahan'] = "
        $('#member-report').addClass('active');
        ";
        return view('report.member', $data);
    }
    public function balancesheetReport()
    {
        abort_if(Gate::denies('neraca_read'), 403);
        $data = Template::get();
        $data['jsTambahan'] = "
        $('#balancesheet-report').addClass('active');
        
        $('#report').addClass('open active');
        ";
        return view('report.balancesheet', $data);
    }
    public function loanReport()
    {

        abort_if(Gate::denies('loanreport_read'), 403);
        $data = Template::get();
        $data['jsTambahan'] = "
        $('#loan-report-bil').addClass('active');
        
        $('#loan-report').addClass('open active');
        ";
        return view('report.loan', $data);
    }
}