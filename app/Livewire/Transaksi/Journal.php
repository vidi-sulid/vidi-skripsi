<?php

namespace App\Livewire\Transaksi;

use App\Models\Transaksi\Journal as TransaksiJournal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class Journal extends Component
{

    public $listeners = ['rekeningSelected', 'discountModalRefresh'];
    public $mutation = array();
    public $rekening;
    public $nama;
    public $invoice;
    public $keterangan;
    public $nominal;
    public $jenis;

    protected $rules = [
        'rekening' => 'required',
        'keterangan' => 'required',
        'nominal' => 'required|numeric|min:0.01',
    ];
    public function mount()
    {
        $this->jenis = "pemasukan";
    }
    public function render()
    {
        $data['data'] =  session()->get('data_jurnal', []);
        return view('livewire.transaksi.journal', $data);
    }
    public function rekeningSelected($member)
    {
        $this->rekening = $member['rekening'];
        $this->nama = $member['name'];
        $this->invoice = invoice("KKK");
    }

    public function simpanTmp()
    {

        $this->nominal  = filter_var($this->nominal, FILTER_SANITIZE_NUMBER_INT);
        $this->validate();
        $cartItems = session()->get('data_jurnal', []);
        // Add the product to the cart session
        $id = uniqid();
        $debet = $kredit = 0;
        if ($this->jenis == "pemasukan") {
            $kredit = $this->nominal;
        } else {
            $debet = $this->nominal;
        }
        $cartItems[$id] = [
            'id'      => $this->rekening,
            'name'    => $this->nama,
            'jenis'   => $this->jenis,
            'keterangan' => $this->keterangan,
            'debet' => $debet,
            'kredit' => $kredit, // Adjust as needed
        ];

        session()->put('data_jurnal', $cartItems);
        $this->reset();
    }
    public function removeItem($row_id)
    {

        $cartItems = session()->get('data_jurnal', []);
        unset($cartItems[$row_id]);
        session()->put('data_jurnal', $cartItems);
    }

    public function saveData()
    {
        $invoice = invoice("KKK", true);
        $data = session()->get('data_jurnal', []);
        foreach ($data as $key => $value) {

            $mutation = [
                "invoice"     => $invoice,
                "date"        => getTgl(),
                "rekening"    => $value['id'],
                "description" => $value['keterangan'],

                "debit"       => $value['debet'],
                "credit"      => $value['kredit'],
                "username"  => Auth::user()->name
            ];
            TransaksiJournal::create($mutation);
            if ($mutation['debit'] > 0) {
                $mutation['credit'] = $mutation['debit'];
                unset($mutation['debit']);
            } else {
                $mutation['debit'] = $mutation['credit'];
                unset($mutation['credit']);
            }
            $mutation['rekening'] = Auth::user()->rekening_kas;
            TransaksiJournal::create($mutation);
        }

        log_custom("Simpan menu tambah transaksi kas", $data);
        Alert::info('Info Title', 'Berhasil disimpan');

        return redirect()->route('journal-report.index');
    }
}
