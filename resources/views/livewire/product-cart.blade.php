<div>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-warning alert-dismissible" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>
        @endif
        <div class="table-responsive position-relative">
            <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center"
                style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th class="align-middle">Rekening</th>
                        <th class="align-middle text-center">Jenis</th>
                        <th class="align-middle text-center">Keterangan</th>
                        <th class="align-middle text-center">Nominal</th>
                        <th class="align-middle text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPemasukan = 0;
                        $totalPengeluaran = 0;
                    @endphp
                    @if (count($cart_items) > 0)

                        @foreach ($cart_items as $key => $cart_item)
                            @if ($cart_item['jenis'] == 'pengeluaran')
                                @php
                                    $totalPemasukan += String2Number($cart_item['nominal']);
                                @endphp
                            @else
                                @php
                                    $totalPengeluaran += String2Number($cart_item['nominal']);
                                @endphp
                            @endif
                            <tr>
                                <td class="align-middle">
                                    {{ $cart_item['id'] . '-' . $cart_item['name'] }} <br>

                                </td>
                                <td class="align-middle text-center text-center">
                                    {{ $cart_item['jenis'] }}
                                </td>
                                <td>
                                    {{ $cart_item['keterangan'] }}
                                </td>
                                <td class="text-right" align="right">
                                    {{ format_currency(String2Number($cart_item['nominal'])) }}
                                </td>
                                <td class="align-middle text-center">
                                    <a href="#" wire:click.prevent="removeItem('{{ $key }}')">
                                        <i class="bx bx-x-circle font-2xl text-danger"></i>
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">
                                <span class="text-danger">
                                    Please search & select products!
                                </span>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="row justify-content-md-end">
        <div class="col-md-6">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th>Total Pengeluaran</th>
                        <td>(+) {{ format_currency($totalPengeluaran) }}</td>
                    </tr>
                    <tr>
                        <th>Total Pemasukan</th>
                        <td>(-) {{ format_currency($totalPemasukan) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
