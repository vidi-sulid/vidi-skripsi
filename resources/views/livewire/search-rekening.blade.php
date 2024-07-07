<div>
    <div class="position-relative">
        <div class="form-group mb-0">
            <div class="input-group input-group-merge">
                <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search..."
                    aria-describedby="basic-addon-search31" wire:keydown.escape="resetQuery"
                    wire:model.live.debounce.500ms="query" />
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
            @if (count($search_results) > 0)
                <div class="card position-absolute mt-1" style="z-index: 2;left: 0;right: 0;border: 0;">
                    <div class="card-body shadow">
                        <ul class="list-group list-group-flush">
                            @foreach ($search_results['data'] as $result)
                                <li class="list-group-item list-group-item-action">
                                    <a wire:click="resetQuery" href="#"
                                        wire:click.prevent="selectRekening({{ json_encode($result) }})">
                                        {{ $result['rekening'] }} | {{ $result['name'] }}
                                    </a>
                                </li>
                            @endforeach
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
</div>
