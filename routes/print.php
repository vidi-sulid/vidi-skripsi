<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('journal-pdf', function (Request $request) {

    $journal = $request->session()->get('journal');
    // return view('print.journal', ["data" => $journal]);
    $pdf = Pdf::loadView('print.journal', [
        'data' => $journal,
    ])->setPaper('a4', 'landscape');
    $filename = "Journal-" . date("Y-m-d H:i:s") . ".pdf";
    return $pdf->stream($filename);
})->name('journal-pdf.index');


Route::get('member-pdf', function (Request $request) {

    $data = $request->session()->get('member');
    // return view('print.member', ["data" => $data]);
    $pdf = Pdf::loadView('print.member', [
        'data' => $data,
    ])->setPaper('a4', 'landscape');

    $filename = "Member-" . date("Y-m-d H:i:s") . ".pdf";
    return $pdf->stream($filename, ['Content-Disposition' => 'inline']);
})->name('member-pdf.index');

Route::get('loan-pdf', function (Request $request) {

    $data = $request->session()->get('loan');
    // return view('print.loan', ["data" => $data]);
    $pdf = Pdf::loadView('print.loan', [
        'data' => $data,
    ])->setPaper('a4', 'landscape');

    $filename = "Pinjaman-" . date("Y-m-d H:i:s") . ".pdf";
    return $pdf->stream($filename, ['Content-Disposition' => 'inline']);
})->name('loan-pdf.index');


Route::get('balancesheet-pdf', function (Request $request) {

    $data = $request->session()->get('balancesheet');
    $pdf = Pdf::loadView('print.balancesheet', [
        'data' => $data,
    ])->setPaper('a4');

    $filename = "Neraca-" . date("Y-m-d H:i:s") . ".pdf";
    return $pdf->stream($filename, ['Content-Disposition' => 'inline']);
})->name('balancesheet-pdf.index');


Route::get('profitloss-pdf', function (Request $request) {

    $data = $request->session()->get('profitloss');
    $pdf = Pdf::loadView('print.profitloss', [
        'data' => $data,
    ])->setPaper('a4');

    $filename = "Labarugi-" . date("Y-m-d H:i:s") . ".pdf";
    return $pdf->stream($filename, ['Content-Disposition' => 'inline']);
})->name('profitloss-pdf.index');

Route::get('bookledger-pdf', function (Request $request) {

    $data = $request->session()->get('bookledger');

    // return view('print.boodledger', ["data" => $data]);
    $pdf = Pdf::loadView('print.bookledger', [
        'data' => $data,
    ])->setPaper('a4', 'landscape');

    $filename = "Bukubesar-" . date("Y-m-d H:i:s") . ".pdf";
    return $pdf->stream($filename, ['Content-Disposition' => 'inline']);
})->name('bookledger-pdf.index');

Route::get('aset-pdf', function (Request $request) {

    $data = $request->session()->get('aset');
    // return view('print.aset', ["data" => $data]);
    $pdf = Pdf::loadView('print.aset', [
        'data' => $data,
    ])->setPaper('a4', 'landscape');

    $filename = "Aset-" . date("Y-m-d H:i:s") . ".pdf";
    return $pdf->stream($filename, ['Content-Disposition' => 'inline']);
})->name('aset-pdf.index');

Route::get('card-pdf', function (Request $request) {

    $mutasi = $request->session()->get('card_mutation');
    $type = $request->session()->get('card_type');
    $dataMember = $request->session()->get('card_data');
    $landscpae = "";
    $view = "card_saving";
    if ($type == "loan") {
        $landscpae = "landscape";
        $view = "card_loan";
    }

    $data['mutation'] = $mutasi;
    $data['data'] = $dataMember;
    // return view('print.' . $view, $data);
    $pdf = Pdf::loadView('print.' . $view, $data)->setPaper('a4', $landscpae);

    $filename = "Card-" . date("Y-m-d H:i:s") . ".pdf";
    return $pdf->stream($filename, ['Content-Disposition' => 'inline']);
})->name('card-pdf.index');