<?php

use App\Models\System\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

function menu()
{
    $data = array(
        "Coa" => array("Coa" => ["Write", "Read", "Update", "Delete"]),
        "Pembukuan" => array("Journal" => ["Write", "Read", "Update", "Delete"]),
        "Master Golongan Aset" => array("ProductAset" => ["Write", "Read", "Update", "Delete"]),

    );
    return $data;
}

if (!function_exists('String2Number')) {
    function String2Number($cKey)
    {
        return str_replace(",", "", $cKey);
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