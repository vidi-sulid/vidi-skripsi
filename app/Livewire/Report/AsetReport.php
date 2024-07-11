<?php

namespace App\Livewire\Report;

use App\Library\AsetCalculation;
use App\Models\Transaksi\Aset;
use App\Models\Transaksi\AsetMutation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

class AsetReport extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $productAset;
    public $periode;
    public $product_aset_id;
    public $sale_status;
    public $payment_status;
    public $postingStatus = false;

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
        $exists = AsetMutation::where('description', 'like', 'Penyusutan aset ' . $this->periode . "%")->exists();

        if ($exists) {
            $this->postingStatus = true;
        } else {
            $this->postingStatus = false;
        }
    }

    public function periodeUpdate()
    {
    }
    public function render()
    {
        $tanggalFilter = date("Y-m-t", strtotime($this->periode));
        $aset = Aset::with(['product'])->whereDate('purchase_date', '<=', $tanggalFilter)

            ->orderBy('purchase_date', 'desc')->paginate(2);
        session()->put('aset', $aset);
        session()->put('periode', $this->periode);
        $exists = AsetMutation::where('description', 'like', 'Penyusutan aset ' . $this->periode . "%")->exists();
        if ($exists) {

            $this->postingStatus = true;
        } else {
            $this->postingStatus = false;
        }
        return view('livewire.report.aset-report', [
            'aset' => $aset
        ]);
    }

    public function generateReport()
    {
        $this->validate();
        $this->render();
    }

    public function posting()
    {
        $tanggalFilter = date("Y-m-t", strtotime($this->periode));
        $aset = Aset::with(['product'])->whereDate('purchase_date', '<=', $tanggalFilter)

            ->orderBy('purchase_date', 'desc')->get();
        $invoice = invoice("ASP", true);
        $tgl = getTgl();
        $username = Auth::user()->name;
        foreach ($aset as $value) {
            $tanggal = date('Y-m-01', strtotime($this->periode));
            $vaAset = AsetCalculation::get($value, $tanggal);
            $vaMutasi = array(
                "invoice" => $invoice,
                "asset_id" => $value->code,
                "date" => $tgl,
                "username" => $username,
                "description" => "Penyusutan aset " . $this->periode . " " . $value->name,
                "credit_book_value" => $vaAset['penyusutan']
            );
            AsetMutation::create($vaMutasi);
        }

        UpdAsetPenyusutan($invoice);
        return redirect()->route('journal-report.index');
    }
}
