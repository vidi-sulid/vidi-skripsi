<?php

namespace App\Livewire\Transaksi;

use App\Library\Member;
use App\Models\Master\Saving;
use App\Models\Transaksi\Journal;
use App\Models\Transaksi\Loan;
use App\Models\Transaksi\LoanMutation;
use App\Models\Transaksi\SavingMutation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class BookTransfer extends Component
{
    public $listeners = ['rekeningSelected', 'discountModalRefresh'];
    public $rekening;
    public $nama;
    public $invoice;
    public $type;
    public $data;
    public $keterangan;
    public $mutation = array();
    public $loan_amount;
    public $bakidebet;
    public $tunggakanPokok;
    public $tunggakanBunga;
    public $setoranWajib;
    public $setoranPokok;
    public $saldo;
    public $jenis = "D";
    public $pokokKredit = 0;
    public $bungaKredit = 0;
    public $nominalSimpanan = 0;
    public $nominalTotal = 0;
    public $totalDebet = 0;
    public $totalKredit = 0;

    protected $rules = [
        'rekening' => 'required',
        'keterangan' => 'required',
        'jenis' => 'required',
        'pokokKredit' => 'nullable|numeric|required_if:bungaKredit,0',
        'bungaKredit' => 'nullable|numeric|required_if:pokokKredit,0',
        // 'nominal' => 'numeric',
    ];

    public function mount()
    {
        $this->jenis = "D";
    }

    public function render()
    {

        $data['dataTmp'] =  session()->get('data_pemindahbukuan', []);
        return view('livewire.transaksi.book-transfer', $data);
    }
    public function rekeningSelected($member)
    {
        $this->rekening = $member['rekening'];
        $this->nama = $member['name'];
        $this->type = $member['type'];
        $this->invoice = invoice("PPP");

        if ($member['type'] == "loan") {
            $loan = Loan::where("rekening", $this->rekening)->get();
            $this->data = Member::loan(getTgl(), $loan);
            $this->mutation = LoanMutation::where("rekening", $this->rekening)->where("date", "<=", getTgl())->get();
            $this->keterangan = "Pembayaran angsuran pinjaman an " . $this->data[0]->member->name;
            $this->loan_amount = number_format($this->data[0]->loan_amount);
            $this->bakidebet = number_format($this->data[0]->bakidebet);
            $this->tunggakanBunga = number_format($this->data[0]->tunggakanBunga);
            $this->tunggakanPokok = number_format($this->data[0]->tunggakanPokok);
        } else if ($this->type == "saving") {
            $this->data = Saving::with(['product'])->where("rekening", $this->rekening)->first();
            $this->saldo = number_format(Member::saldoSimpanan($this->rekening, getTgl()));
            $this->mutation = SavingMutation::where("rekening", $this->rekening)->where("date", "<=", getTgl())->get();
            $this->setoranWajib = number_format($this->data->product->mandatory_deposit);
            $this->setoranPokok = number_format($this->data->product->principial_deposit);
            $this->keterangan = " an " . $this->nama;
        } else {
            $this->keterangan = "";
        }
        session()->put('card_mutation', $this->mutation);
        session()->put('card_type', $this->type);
        session()->put('card_data', $this->data);
    }

    public function simpanTmp()
    {
        $cartItems = session()->get('data_pemindahbukuan', []);

        $this->nominalSimpanan  = filter_var($this->nominalSimpanan, FILTER_SANITIZE_NUMBER_INT);
        // Add the product to the cart session
        $id = uniqid();
        $debet = $kredit = 0;
        if ($this->type == "loan") {

            if ($this->jenis == "D") {
                $a = "D";
                $this->validate([
                    'jenis' => [
                        function ($attribute, $value, $fail) use ($a) {
                            if ($value == "D") {
                                $fail('Pinjaman tidak boleh berposisi debet');
                            }
                        },
                    ],
                ]);
            } else {
                $bakidebet = Member::bakidebet($this->rekening, getTgl());
                $this->validate([
                    'pokokKredit' => [
                        'numeric',
                        function ($attribute, $value, $fail) use ($bakidebet) {
                            if ($value > $bakidebet) {
                                $fail('Pokok Kredit tidak boleh lebih besar dari Bakidebet.');
                            }
                        },
                    ],
                ]);
                $kredit = $this->pokokKredit + $this->bungaKredit;
            }
        } else if ($this->type == "saving" || $this->type == "coa") {
            if ($this->jenis == "D") {
                if ($this->type == "saving") {
                    $saldo = Member::saldoSimpanan($this->rekening, getTgl());
                    $this->validate([
                        'nominalSimpanan' => [
                            'numeric',
                            function ($attribute, $value, $fail) use ($saldo) {
                                if ($value > $saldo) {
                                    $fail('Penarikan tidak boleh lebih besar dari saldo.');
                                }
                            },
                        ],
                    ]);
                }


                $debet = $this->nominalSimpanan;
            } else {
                $kredit = $this->nominalSimpanan;
            }
        }
        $this->nominalTotal = $debet + $kredit;
        $this->totalDebet += $debet;
        $this->totalKredit += $kredit;
        $this->validate([
            'nominalTotal' => 'required|numeric|min:0.01'
        ]);
        $cartItems[$id] = [
            'id'      => $this->rekening,
            'name'    => $this->nama,
            'jenis'   => $this->jenis,
            'keterangan' => $this->keterangan,
            'debet' => $debet,
            'kredit' => $kredit,
            'pokokKredit' => $this->pokokKredit,
            'bungaKredit' => $this->bungaKredit,
            'type' => $this->type
        ];

        session()->put('data_pemindahbukuan', $cartItems);
        $this->reset();
    }

    public function removeItem($row_id)
    {

        $cartItems = session()->get('data_pemindahbukuan', []);
        unset($cartItems[$row_id]);
        session()->put('data_pemindahbukuan', $cartItems);
    }

    public function saveData()
    {
        $invoice = invoice("PPP", true);
        $data = session()->get('data_pemindahbukuan', []);
        foreach ($data as $key => $value) {
            if ($value['type'] == "coa") {
                $mutation = [
                    "invoice"     => $invoice,
                    "date"        => getTgl(),
                    "rekening"    => $value['id'],
                    "description" => $value['keterangan'],

                    "debit"       => $value['debet'],
                    "credit"      => $value['kredit'],
                    "username"  => Auth::user()->name
                ];
                Journal::create($mutation);
            } else if ($value['type'] == "saving") {
                $mutation = [
                    "invoice"         => $invoice,
                    "date"            => getTgl(),
                    "rekening"        => $value['id'],
                    "codetransaction" => '01',
                    "description"     => $value['keterangan'],

                    "debit"           => $value['debet'],
                    "credit"          => $value['kredit'],
                    "username"        => Auth::user()->name,
                    "cash"            => 'N'
                ];
                SavingMutation::create($mutation);
                UpdateJournalSaving($invoice);
            } else if ($value['type'] == "loan") {
                $mutation = [
                    "status"          => 0,
                    "invoice"         => $invoice,
                    "date"            => getTgl(),
                    "rekening"        => $value['id'],
                    "description"     => $value['keterangan'],
                    "credit"          => $data['pokokKredit'],
                    "credit_interest" => $data['bungaKredit'],
                    "username"        => Auth::user()->name,
                    "cash"            => 'N'
                ];
                LoanMutation::create($mutation);
                UpdateJournalLoan($data['invoice']);
            }
        }

        Alert::info('Info Title', 'Berhasil disimpan');
        log_custom("Simpan menu tambah transaksi pemindahbukuan", $data);

        return redirect()->route('journal-report.index');
    }
}
