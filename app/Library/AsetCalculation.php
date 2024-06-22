<?php

namespace App\Library;

use Carbon\Carbon;

class AsetCalculation
{
    static function get($aset, $date)
    {
        $date = date("Y-m-01", strtotime($date));
        $tanggalAwalAset = date("Y-m-01", strtotime($aset->purchase_date));
        $va['ke'] = differenceDay($tanggalAwalAset, $date, true) + 1;
        $va['penyusutan'] = ($aset->price - $aset->residual_value) / $aset->depreciation_period;

        $va['penyusutanAwal'] = max($va['penyusutan'] * ($va['ke'] - 1), 0);
        $va['penyusutanAkhir'] = $va['penyusutan'] * $va['ke'];
        if ($va['ke'] > $aset->lama) {
            $vaPenyusutan['penyusutan'] = 0;
            $value['ke'] = $aset->depreciation_period;
        }
        return $va;
    }

    static function getKe($date_start, $date_end)
    {


        $tanggal_pembelian = Carbon::parse('2024-01-31');
        // Tanggal sekarang
        $tanggal_sekarang = Carbon::parse('2024-02-28');
        $tanggal_berikutnya = Carbon::parse('2024-03-31');

        // Hitung selisih bulan
        $selisih_bulan_pembelian_sekarang = round($tanggal_pembelian->diffInMonths($tanggal_sekarang, false));
        $selisih_bulan_sekarang_berikutnya = round($tanggal_sekarang->diffInMonths($tanggal_berikutnya, false));

        echo "Penyusutan terjadi setelah $selisih_bulan_pembelian_sekarang bulan.\n";
        echo "Penyusutan terjadi setelah $selisih_bulan_sekarang_berikutnya bulan.\n";
        exit();
    }
}
