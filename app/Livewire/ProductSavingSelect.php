<?php

namespace App\Livewire;

use App\Models\Master\ProductSaving;
use Livewire\Component;

class ProductSavingSelect extends Component
{
    public $selectedOption;
    public $rekeningPokok;
    public $rekeningWajib;
    public $kodeCif;
    public $product;
    public $nominalPokok;
    public $nominalWajib = 0;

    public function mount()
    {
        $this->nominalPokok = 0;
        $this->kodeCif = getLastMemberCode();
    }

    public function render()
    {
        return view('livewire.product-saving-select');
    }



    public function handleSelectChange($value)
    {
        $this->rekeningWajib = "01." . $value . "." . $this->kodeCif . ".001";
        $data = ProductSaving::where("code", $value)->first();
        if ($data) {
            $this->nominalWajib = 100000; // format_currency($data->mandatory_deposit);
        }
    }
    public function handleSelectChangePokok($value)
    {
        $this->rekeningPokok = "01." . $value . "." . $this->kodeCif . ".001";
        $data = ProductSaving::where("code", $value)->first();
        if ($data) {
            $this->nominalPokok = 50000; //format_currency($data->principal_deposit);
        }
    }
}
