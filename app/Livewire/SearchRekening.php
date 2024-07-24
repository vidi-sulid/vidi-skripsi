<?php

namespace App\Livewire;

use App\Models\Master\Coa;
use App\Models\Master\Saving;
use App\Models\Transaksi\Loan;
use Livewire\Component;

use Illuminate\Support\Collection;

class SearchRekening extends Component
{
    public $query;
    public $search_results;
    public $rekening;
    public $tes;
    public $rekeningCoa;

    protected $rules = [
        'keterangan' => 'required',
    ];
    public function mount()
    {
        $this->tes = "sdkfj";
        $this->query = '';
        $this->search_results = array();
    }

    public function render()
    {
        return view('livewire.search-rekening');
    }


    public function updatedQuery()
    {

        $data = array();
        $rekening = $this->query;

        if ($rekening != "") {
            $loan = Loan::whereHas('member', function ($query) use ($rekening) {
                $query->where("name", "like", "%$rekening%");
            })->get();
            foreach ($loan as $value) {

                $data['data'][] = array("rekening" => $value->rekening, "name" => $value->member->name, "type" => "loan");
            }

            $loan = Saving::whereHas('member', function ($query) use ($rekening) {
                $query->where("name", "like", "%$rekening%");
            })->get();

            foreach ($loan as $value) {
                $data['data'][] = array("rekening" => $value->rekening, "name" => $value->member->name, "type" => "saving");
            }
            if ($this->rekeningCoa != "") {
                $loan = Coa::where('name', "like", "%$rekening%")->where("type", 0)->get();
                foreach ($loan as $value) {
                    $data['data'][] = array("rekening" => $value->code, "name" => $value->name, "type" => "coa");
                }
            }
            $this->search_results = $data;
        }
    }

    public function loadMore()
    {
        $this->updatedQuery();
    }

    public function resetQuery()
    {
        $this->query = '';
        $this->search_results = array();
    }

    public function selectRekening($product)
    {
        $this->rekening = $product['rekening'];
        // $this->validate();
        // $product['keterangan'] = $this->keterangan;
        // $product['jenis'] = $this->jenis;
        // $product['nominal'] = $this->nominal;
        $this->dispatch('rekeningSelected', $product);
    }
}
