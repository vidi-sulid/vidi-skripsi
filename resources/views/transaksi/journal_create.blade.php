@extends('layouts.app')
@section('content')
    <livewire:search-product />
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-body">
                <form id="purchase-form" action="{{ route('journal.store') }}" method="POST">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="reference">Reference <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="reference" required readonly
                                    value="PR">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="from-group">
                                <div class="form-group">
                                    <label for="date">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="date" required
                                        value="{{ now()->format('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <livewire:product-cart :cartInstance="'purchase'" />

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            Create Purchase <i class="bi bi-check"></i>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
@section('addon_js')
    <script>
        $(document).ready(function() {
            $('#paid_amount').maskMoney({
                prefix: '{{ settings()->currency->symbol }}',
                thousands: '{{ settings()->currency->thousand_separator }}',
                decimal: '{{ settings()->currency->decimal_separator }}',
                allowZero: true,
            });

            $('#getTotalAmount').click(function() {
                $('#paid_amount').maskMoney('mask', {{ Cart::instance('purchase')->total() }});
            });

            $('#purchase-form').submit(function() {
                var paid_amount = $('#paid_amount').maskMoney('unmasked')[0];
                $('#paid_amount').val(paid_amount);
            });
        });
    </script>
@endsection
