<?php

namespace Database\Seeders;

use App\Models\Master\Coa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data  = [
            ["code" => 1, "name" => "Aktiva", "type" => 1],
            ["code" => 2, "name" => "Pasiva", "type" => 1],
            ["code" => 3, "name" => "Ekuitas", "type" => 1],
            ["code" => 4, "name" => "Pendapatan", "type" => 1],
            ["code" => 5, "name" => "Beban", "type" => 1],
            ["code" => '1.100', "name" => "Kas", "type" => 1],
            ["code" => '1.100.10', "name" => "Kas Besar", "type" => 0],
            ["code" => '1.100.20', "name" => "Kas Teller", "type" => 0],
            ["code" => '1.110', "name" => "Penempatan Pada Bank Lain", "type" => 1],
            ["code" => '1.110.10', "name" => "BCA", "type" => 0],
            ["code" => '1.110.20', "name" => "BRI", "type" => 0],
            ["code" => '1.150', "name" => "Aset Inventaris", "type" => 1],
            ["code" => '1.150.10', "name" => "Aset Inventaris Perlengkapan Kantor", "type" => 0],
            ["code" => '1.151', "name" => "Akumulasi Penyusutan Aset Inventaris", "type" => 1],
            ["code" => '1.151.10', "name" => "Akumulasi Penyusutan Aset Inventaris", "type" => 0],
            ["code" => '4.500', "name" => "Pendapatan Lainnya ", "type" => 1],
            ["code" => '4.500.10', "name" => "Pendapatan Lainnya", "type" => 0],
            ["code" => '5.500', "name" => "Beban Administrasi Umum ", "type" => 1],
            ["code" => '5.500.10', "name" => "Beban Penyususutan", "type" => 0],
        ];
        Coa::insert($data);;
    }
}