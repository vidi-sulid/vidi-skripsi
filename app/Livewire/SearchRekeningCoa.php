<?php

namespace App\Livewire;

use App\Models\Master\Coa;
use Livewire\Component;

class SearchRekeningCoa extends Component
{
    public $query;
    public $search_results;
    public $rekening;
    public function render()
    {
        return view('livewire.search-rekening-coa');
    }

    public function updatedQuery()
    {

        $data = array();
        $rekening = $this->query;

        if ($rekening != "") {
            $loan = Coa::where("name", "like", "%$rekening%")->where("type", "0")->orderBy("code")->get();
            foreach ($loan as $value) {

                $data['data'][] = array("rekening" => $value->code, "name" => $value->name);
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

        $this->dispatch('rekeningSelected', $product);
    }
}
