<?php

use App\Models\System\Invoice;
use App\Models\System\Setting;
use App\Models\Transaksi\AsetMutation;
use App\Models\Transaksi\Journal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

function menu()
{
    $data = array(
        "Coa" => array("Coa" => ["Write", "Read", "Update", "Delete"]),
        "Pembukuan" => array("Journal" => ["Write", "Read", "Update", "Delete"]),
        "Master Golongan Aset" => array("ProductAset" => ["Write", "Read", "Update", "Delete"]),
        "Master Golongan Simpanan" => array("ProductSaving" => ["Write", "Read", "Update", "Delete"]),
        "Master Golongan Pinjaman" => array("ProductLoan" => ["Write", "Read", "Update", "Delete"]),
        "Master Anggota" => array("Member" => ["Write", "Read", "Update", "Delete"]),
        "Pembelian Aset" => array("Aset" => ["Write", "Read", "Update", "Delete"]),

    );
    return $data;
}

if (!function_exists('String2Number')) {
    function String2Number($cKey)
    {
        return str_replace(".", "", $cKey);
    }
}
if (!function_exists('format_currency')) {
    function format_currency($value, $format = true)
    {
        if (!$format) {
            return $value;
        }

        $settings = settings();
        $position = $settings->default_currency_position;
        $symbol = $settings->currency->symbol;
        $decimal_separator = $settings->currency->decimal_separator;
        $thousand_separator = $settings->currency->thousand_separator;
        $value = String2Number($value);
        if ($position == 'prefix') {
            $formatted_value = $symbol . number_format($value, 2, $decimal_separator, $thousand_separator);
        } else {
            $formatted_value = number_format($value, 2, $decimal_separator, $thousand_separator) . $symbol;
        }

        return $formatted_value;
    }
}

if (!function_exists('convertRupiahToNumber')) {
    function convertRupiahToNumber($rupiah)
    {
        // Hapus awalan 'Rp ' dan tanda pemisah ribuan
        $number = str_replace(['Rp ', ',', '.'], '', $rupiah);

        // Ubah string menjadi angka (float)
        $number = (float) $number;

        return $number;
    }
}
if (!function_exists('settings')) {
    function settings()
    {
        $settings = cache()->remember('settings', 24 * 60, function () {
            return  Setting::firstOrFail();
        });

        return $settings;
    }
}


if (!function_exists('make_reference_id')) {
    function make_reference_id($prefix, $number)
    {
        $padded_text = $prefix . '-' . str_pad($number, 5, 0, STR_PAD_LEFT);

        return $padded_text;
    }
}

if (!function_exists('log_custom')) {
    function log_custom($info, $data = [])
    {
        $userName = Auth::user()->name;
        Log::info("$userName $info", $data);
    }
}

if (!function_exists('invoice')) {
    function invoice($prefix, $lUpdate = false)
    {
        $year = now()->year;
        $month = now()->month;
        $day = now()->day;
        $lastInvoice = Invoice::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereDay('created_at', $day)
            ->where("invoice_number", 'like', "%$prefix%")
            ->orderBy('id', 'desc')
            ->first();
        $lastNumber    = $lastInvoice ? (int)substr($lastInvoice->invoice_number, -4) : 0;
        $newNumber     = sprintf('%04d', $lastNumber + 1);
        $isodate       = sprintf("%04d%02d%02d", $year, $month, $day);
        $invoiceNumber = "{$prefix}-{$isodate}-{$newNumber}";

        if ($lUpdate) Invoice::create(['invoice_number' => $invoiceNumber]);

        return $invoiceNumber;
    }
}

function differenceDay($date_start, $date_end, $month = false)
{
    $date_start = Carbon::createFromFormat('Y-m-d', $date_start);
    $date_end = Carbon::createFromFormat('Y-m-d', $date_end);

    if ($month) {
        return  $date_start->diffInMonths($date_end);
    }
    return  $date_start->diffInDays($date_end);
}

function getName($id, $table, $field = 'name', $where = '')
{
    $cResult = "";
    $where = ($where == '') ? 'code' : $where;
    $data = DB::select("select $field name from $table where $where ='$id'");
    foreach ($data as $key => $value) {
        $cResult = $value->name;
    }
    return $cResult;
}


function UpdAset($invoice)
{
    $vaMutasi = AsetMutation::with(['asets'])->where("invoice", $invoice)->get();
    foreach ($vaMutasi as $key => $value) {
        $mutation = [
            "invoice"     => $value->invoice,
            "date"        => $value->date,
            "rekening"    => getName($value->asets->product_asset_id, "product_asets", "account_aset", "id"),
            "description" => $value->description,
            "debit"       => $value->debit_price,
            "credit"      => $value->credit_price,
            "created_by"  => $value->username
        ];
        Journal::create($mutation);
        if ($mutation['debit'] > 0) {
            $mutation['credit'] = $mutation['debit'];
            unset($mutation['debit']);
        } else {
            $mutation['debit'] = $mutation['credit'];
            unset($mutation['credit']);
        }
        $mutation['rekening'] = Auth::user()->rekening_kas;
        Journal::create($mutation);
    }
}
