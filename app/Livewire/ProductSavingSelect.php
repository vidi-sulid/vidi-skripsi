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
    public $nominalWajib;
    protected $listeners = ['postAdded' => 'incrementPostCount', "resetComponent"];


    public function resetComponent()
    {
        $this->reset(); // Reset component state here
    }
    public function mount()
    {

        $this->dispatch('post-created');
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
            $this->nominalWajib =  number_format($data->mandatory_deposit);
        }
    }
    public function handleSelectChangePokok($value)
    {
        $this->rekeningPokok = "01." . $value . "." . $this->kodeCif . ".001";
        $data = ProductSaving::where("code", $value)->first();
        if ($data) {
            $this->nominalPokok = number_format($data->principal_deposit);
        }
    }
}
