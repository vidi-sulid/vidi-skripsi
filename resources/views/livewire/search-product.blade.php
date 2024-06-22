<div class="position-relative">
    <div class="card mb-0 border-0 shadow-sm">
        <div class="card-body">
            <div class="form-group mb-0">
                <label for="jenis" class="form-label">Jenis</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis" id="pengeluaran" checked
                            value="pengeluaran" wire:model="jenis">
                        <label class="form-check-label" for="pengeluaran">Pengeluaran</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input " type="radio" name="jenis" id="pemasukan" value="pemasukan"
                            wire:model="jenis">
                        <label class="form-check-label" for="pemasukan">Pemasukan</label>
                    </div>
                </div>
            </div>
            <div class="form-group mb-0">
                <label for="nominal" class="form-label">Nominal</label>
                <input type="text" id="nominal" class="form-control numeral-mask" placeholder="Nominal..."
                    wire:model="nominal" />
                @error('nominal')
                    <span class="text-danger mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-0 mt-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="text" id="keterangan" class="form-control" placeholder="Keterangan..."
                    wire:model="keterangan" />
                @error('keterangan')
                    <span class="text-danger mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-0">
                <label for="searchInput" class="form-label">Rekening</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search..." aria-label="Search..."
                        aria-describedby="basic-addon-search31" wire:keydown.escape="resetQuery"
                        wire:model.live.debounce.500ms="query" />
                </div>
            </div>
        </div>
    </div>

    <div wire:loading class="card position-absolute mt-1 border-0" style="z-index: 1;left: 0;right: 0;">
        <div class="card-body shadow">
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    @if (!empty($query))
        <div wire:click="resetQuery" class="position-fixed w-100 h-100"
            style="left: 0; top: 0; right: 0; bottom: 0;z-index: 1;"></div>
        @if ($search_results->isNotEmpty())
            <div class="card position-absolute mt-1" style="z-index: 2;left: 0;right: 0;border: 0;">
                <div class="card-body shadow">
                    <ul class="list-group list-group-flush">
                        @foreach ($search_results as $result)
                            <li class="list-group-item list-group-item-action">
                                <a wire:click="resetQuery" wire:click.prevent="selectProduct({{ $result }})"
                                    href="#">
                                    {{ $result->code }} | {{ $result->name }}
                                </a>
                            </li>
                        @endforeach
                        @if ($search_results->count() >= $how_many)
                            <li class="list-group-item list-group-item-action text-center">
                                <a wire:click.prevent="loadMore" class="btn btn-primary btn-sm" href="#">
                                    Load More <i class="bi bi-arrow-down-circle"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        @else
            <div class="card position-absolute mt-1 border-0" style="z-index: 1;left: 0;right: 0;">
                <div class="card-body shadow">
                    <div class="alert alert-warning mb-0">
                        No Product Found....
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>

@section('addon_js')
    <script>
        $('.numeral-masks').toArray().forEach(function(field) {
            var cleave = new Cleave(field, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
                prefix: 'Rp ',
                noImmediatePrefix: true,
                rawValueTrimPrefix: true
            });
        });
    </script>
@endsection
