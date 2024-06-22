<?php

namespace App\Livewire\Report;

use App\Models\Transaksi\Aset;
use Livewire\Component;
use Livewire\WithPagination;

class AsetReport extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $productAset;
    public $periode;
    public $product_aset_id;
    public $sale_status;
    public $payment_status;

    protected $rules = [
        'periode'   => 'required|',
    ];

    public function mount($productAset)
    {
        $this->productAset = $productAset;
        $this->periode = date("Y-m");
        $this->product_aset_id = '';
        $this->sale_status = '';
        $this->payment_status = '';
    }

    public function render()
    {
        $tanggalFilter = date("Y-m-t", strtotime($this->periode));
        $aset = Aset::whereDate('purchase_date', '<=', $tanggalFilter)

            ->orderBy('purchase_date', 'desc')->paginate(2);

        return view('livewire.report.aset-report', [
            'aset' => $aset
        ]);
    }

    public function generateReport()
    {
        $this->validate();
        $this->render();
    }
}
