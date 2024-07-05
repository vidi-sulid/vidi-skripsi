<?php

use App\Models\Master\Member;
use App\Models\System\Config;
use App\Models\System\Invoice;
use App\Models\System\Setting;
use App\Models\Transaksi\AsetMutation;
use App\Models\Transaksi\Journal;
use App\Models\Transaksi\SavingMutation;
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

function getWorks()
{
    $Works = [
        '001' => 'Belum/Tidak Bekerja',
        '002' => 'Mengurus Rumah Tangga',
        '003' => 'Pelajar/Mahasiswa',
        '004' => 'Pensiunan',
        '005' => 'Tukang Cukur',
        '006' => 'Tukang Listrik',
        '007' => 'Tukang Batu',
        '008' => 'Tukang Kayu',
        '009' => 'Tukang Sol Sepatu',
        '010' => 'Tukang Las/Pandai Besi',
        '011' => 'Tukang Jahit',
        '012' => 'Tukang Gigi',
        '013' => 'Penata Rias',
        '014' => 'Penata Busana',
        '015' => 'Penata Rambut',
        '016' => 'Mekanik',
        '017' => 'Seniman',
        '018' => 'Tabib',
        '019' => 'Paraji',
        '020' => 'Perancang Busana',
        '021' => 'Penterjemah',
        '022' => 'Imam Masjid',
        '023' => 'Pendeta',
        '024' => 'Pastor',
        '025' => 'Wartawan',
        '026' => 'Ustadz/Mubaligh',
        '027' => 'Juru Masak',
        '028' => 'Pelayan Negeri Sipil',
        '029' => 'Tentara Nasional Indonesia',
        '030' => 'Kepolisian RI',
        '031' => 'Perdagangan',
        '032' => 'Petani/Pekebun',
        '033' => 'Peternak',
        '034' => 'Nelayan/Perikanan',
        '035' => 'Industri',
        '036' => 'Konstruksi',
        '037' => 'Transportasi',
        '038' => 'Karyawan Swasta',
        '039' => 'Karyawan BUMN',
        '040' => 'Karyawan BUMD',
        '041' => 'Karyawan Honorer',
        '042' => 'Buruh Harian Lepas',
        '043' => 'Buruh Tani/Perkebunan',
        '044' => 'Buruh Nelayan/Perikanan',
        '045' => 'Buruh Peternakan',
        '046' => 'Pembantu Rumah Tangga',
        '047' => 'Presiden',
        '048' => 'Wakil Presiden',
        '049' => 'Anggota DPR-RI',
        '050' => 'Anggota DPD',
        '051' => 'Anggota BPK',
        '052' => 'Anggota Mahkamah Konstitusi',
        '053' => 'Anggota Kabinet/Kementerian',
        '054' => 'Duta Besar',
        '055' => 'Gubernur',
        '056' => 'Wakil Gubernur',
        '057' => 'Bupati',
        '058' => 'Wakil Bupati',
        '059' => 'Walikota',
        '060' => 'Wakil Walikota',
        '061' => 'Anggota DPRD Provinsi',
        '062' => 'Anggota DPRD Kabupaten/Kota',
        '063' => 'Dosen',
        '064' => 'Guru',
        '065' => 'Pilot',
        '066' => 'Pengacara',
        '067' => 'Notaris',
        '068' => 'Arsitek',
        '069' => 'Akuntan',
        '070' => 'Konsultan',
        '071' => 'Dokter',
        '072' => 'Bidan',
        '073' => 'Perawat',
        '074' => 'Apoteker',
        '075' => 'Psikiater/Psikolog',
        '076' => 'Penyiar Televisi',
        '077' => 'Penyiar Radio',
        '078' => 'Pelaut',
        '079' => 'Peneliti',
        '080' => 'Sopir',
        '081' => 'Pialang',
        '082' => 'Paranormal',
        '083' => 'Pedagang',
        '084' => 'Perangkat Desa',
        '085' => 'Kepala Desa',
        '086' => 'Biarawati',
        '087' => 'Wiraswasta',
    ];
    return $Works;
}
function getConfig($code, $default = '')
{
    $data = Config::where('code', $code)->first();
    $value = $data ? $data->value : $default;
    return $value;
}

function getLastMemberCode()
{
    $lastCode = Member::latest('code')->first();
    $lastCode = $lastCode ? intval($lastCode->code) : 0;
    $Code = sprintf("%07d", $lastCode + 1);
    return $Code;
}

function UpdateJournalSaving($invoice)
{
    $mutations   = SavingMutation::where("invoice", $invoice)->get();
    $CashAccount = Auth::user()->rekening_kas;
    foreach ($mutations as $value) {
        $mutation = [
            "invoice"     => $value->invoice,
            "date"        => $value->date,
            "rekening"    => getName($value->savings->product_saving_id, "product_savings", "account_saving"),
            "description" => $value->description,
            "debit"       => $value->debit,
            "credit"      => $value->credit,
            "created_by"  => $value->username
        ];
        Journal::create($mutation);

        if ($value->cash == "K") {
            $mutation['rekening'] = $CashAccount;
            if ($value->debit > 0) {
                $mutation['credit'] = $mutation['debit'];
                unset($mutation['debit']);
                Journal::create($mutation);
            } else {
                $mutation['debit'] = $mutation['credit'];
                unset($mutation['credit']);
                Journal::create($mutation);
            }
        }
    }
}
function getTgl($user_id = '')
{
    return date("Y-m-d");
    $user_id = ($user_id == "") ? Auth::user()->id : $user_id;
    $dTgl = date("Y-m-d");
    $dateNow = Date("Y-m-d H:i:s");
    $data = getDataTable("date", "user_dates", "", "user_id = '$user_id' and date_end > '$dateNow' ", "", "id desc", "1");
    $arr = (array)$data;
    if ($arr) {
        $dTgl = $data[0]->date;
    }
    return $dTgl;
}
