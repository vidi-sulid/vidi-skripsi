@extends('layouts.app')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Aplikasi /</span> Versi
    </h4>

    <div class="row">
        <!-- Timeline Basic-->
        <div class="col-xl-6 mb-6 mb-xl-0">
            <div class="card">
                <h5 class="card-header">Basic</h5>
                <div class="card-body">
                    <ul class="timeline mb-0">
                        @php
                            function getRandomClass()
                            {
                                $classes = ['primary', 'danger', 'warning', 'info', 'success'];
                                return $classes[array_rand($classes)];
                            }
                        @endphp
                        @foreach ($update as $value)
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-{{ getRandomClass() }}"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0">Log</h6>
                                        <small
                                            class="text-muted">{{ Carbon\Carbon::parse($value['date'])->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1">
                                        {{ $value['message'] }}
                                    </p>
                                    <div class="d-flex justify-content-between flex-wrap gap-2 mb-2">
                                        <div class="d-flex flex-wrap align-items-center mb-50">
                                            <div class="avatar avatar-sm me-2">
                                                <img src="{{ asset('assets/img/user.png') }}" alt="Avatar"
                                                    class="rounded-circle" />
                                            </div>
                                            <div>
                                                <p class="mb-0 small fw-medium">{{ $value['author'] }}</p>
                                                <small>CEO of ThemeSelection</small>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->
@endsection
