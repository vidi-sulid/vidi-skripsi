<?php

namespace App\Livewire;

use App\Models\Master\Coa;
use Livewire\Component;
use Illuminate\Support\Collection;

class SearchProduct extends Component
{

    public $query;
    public $search_results;
    public $how_many;
    public $keterangan;
    public $jenis;
    public $nominal;

    protected $rules = [
        'keterangan' => 'required',
    ];
    public function mount()
    {
        $this->query = '';
        $this->how_many = 5;
        $this->jenis = 'pengeluaran';
        $this->nominal = 0;
        $this->search_results = Collection::empty();
    }

    public function render()
    {
        return view('livewire.search-product');
    }


    public function updatedQuery()
    {
        $this->search_results = Coa::where('name', 'like', '%' . $this->query . '%')->where('type', '0')
            ->take($this->how_many)->get();
    }

    public function loadMore()
    {
        $this->how_many += 5;
        $this->updatedQuery();
    }

    public function resetQuery()
    {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
    }

    public function selectProduct($product)
    {

        $this->validate();
        $product['keterangan'] = $this->keterangan;
        $product['jenis'] = $this->jenis;
        $product['nominal'] = $this->nominal;
        $this->dispatch('productSelected', $product);
    }
}