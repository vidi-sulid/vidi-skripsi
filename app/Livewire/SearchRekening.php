<?php

namespace App\Livewire;

use App\Models\Transaksi\Loan;
use Livewire\Component;

use Illuminate\Support\Collection;

class SearchRekening extends Component
{
    public $query;
    public $search_results;
    public $rekening;

    protected $rules = [
        'keterangan' => 'required',
    ];
    public function mount()
    {
        $this->query = '';
        $this->search_results = array();
    }

    public function render()
    {
        return view('livewire.search-rekening');
    }


    public function updatedQuery()
    {

        $rekening = $this->query;
        $loan = Loan::with(['member' => function ($query) use ($rekening) {
            $query->where("name", "like", "%$rekening%");
        }])->get();
        foreach ($loan as $value) {
            $data['data'][] = array("rekening" => $value->rekening, "name" => $value->member->name, "type" => "loan");
        }
        $this->search_results = $data;
    }

    public function loadMore()
    {
        $this->how_many += 5;
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