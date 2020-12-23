@extends('layouts.dashboard')

@section('title')
{{ $pump->label }}
<small class="ml-2 text-uppercase">
    <span class="d-inline-block px-2 rounded bg-{{ $data->state? 'success' : 'danger' }}">{{ $data->state_label }}</span>
</small>
<div class="mt-2">
    <small>
        <a href="{{ route('pumps.index') }}" class="btn btn-sm btn-outline-dark">{{ __('Back') }}</a>
        <a href="{{ route('pumps.edit', [$pump->id]) }}" class="btn btn-sm btn-outline-success">{{ __('Edit') }}</a>
        <a href="{{ route('pumps.data.export', [$pump->id]) }}" class="btn btn-sm btn-outline-danger" title="{{ __('Export last 24-hours data') }}">{{ __('Export Data') }}</a>
        <a href="{{ route('pumps.create') }}" class="btn btn-sm btn-outline-primary">{{ __('Add Pump') }}</a>
    </small>
</div>
@endsection
@section('actions')

<div class="row">
    <div class="border-left col-md-4 pr-3">
        <h3 class="h6 text-muted">{{ __('Last 24-Hrs Runing Time') }}</h3>
        <div class="h3">{{ __(':h hr & :m m', ['h' => $time['hours'], 'm' => $time['minutes']]) }}</div>
    </div>
    <div class="border-left col-md-4 pr-3">
        <h3 class="h6 text-muted">{{ __('Total Running Time') }}</h3>
        <div class="h3">{{ $data->total_running_time }}</div>
    </div>
    <div class="border-left col-md-4 pr-3">
        <h3 class="h6 text-muted">{{ __('Total Start') }}</h3>
        <div class="h3">{{ $data->total_start }}</div>
    </div>
    <div class="border-left col-md-4 pr-3">
        <h3 class="h6 text-muted">{{ __('Leak Stator') }}</h3>
        <div class="h3">{{ $data->ohm_leak_stator }}</div>
    </div>
    <div class="border-left col-md-4 pr-3">
        <h3 class="h6 text-muted">{{ __('Leak Junction') }}</h3>
        <div class="h2">{{ $data->leak_junction }}</div>
    </div>
    <div class="border-left col-md-4 pr-3">
        <h3 class="h6 text-muted">{{ __('Last Update') }}</h3>
        <div class="h3">{{ $data->data_time->diffForHumans() }}</div>
    </div>
</div>

@endsection

@section('content')

<div class="row">
    <div class="col-12">

        <div class="row">
            <div class="col-md-12">
                <div class="card bg-gradient-info">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            <i class="fas fa-th mr-1"></i>
                            {{ __('Temperature Main Bearing') }}
                        </h3>
                        <div class="card-tools">
                            <div class="btn-group btn-group-sm mr-5" role="group" aria-label="{{ __('Chart Periods') }}">
                                <button type="button" data-chart="" data-chart-period="1d" data-chart-resample="5" class="btn btn-light">{{ __('1D') }}</button>
                                <button type="button" data-chart="" data-chart-period="1w" data-chart-resample="10" class="btn btn-light active">{{ __('1W') }}</button>
                                <button type="button" data-chart="" data-chart-period="1m" data-chart-resample="60" class="btn btn-light">{{ __('1M') }}</button>
                            </div>
                            <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas class="chart" id="tempMainBearingChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-gradient-success">
                            <div class="card-header border-0">
                                <h3 class="card-title">
                                    <i class="fas fa-th mr-1"></i>
                                    {{ __('Last 24-Hrs Running Time Per Mins.') }}
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn bg-success btn-sm" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas class="chart" id="stateMinChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Notifications') }}</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body bg-white p-0">
                                <ul class="nav nav-pills flex-column">
                                    @forelse($pump->alerts()->limit(5)->get() as $alert)
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <strong>{{ $alert->type }}</strong>
                                            <small class="text-muted">- <time>{{ $alert->created_at->diffForHumans() }}</time></small>
                                            <span class="float-right text-{{ $alert->severity }}">
                                                <i class="fas fa-exclamation text-sm"></i>
                                                {{ $alert->severity }}</span>
                                        </a>
                                    </li>
                                    @empty
                                    <li class="nav-item">
                                        <span class="nav-link">{{ __('No notifications') }}</span>
                                    </li>
                                    @endforelse
                                </ul>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer bg-white p-0">
                            </div>
                            <!-- /.footer -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-gradient-primary">
                            <div class="card-header border-0">
                                <h3 class="card-title">
                                    <i class="fas fa-th mr-1"></i>
                                    {{ __('Last Week Running Time Hours.') }}
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn bg-primary btn-sm" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas class="chart" id="stateHourChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Thresholds') }}</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body bg-white">
                                <pre>{{ $thresholds ?? '' }}</pre>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('js')
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        (function($) {
            $('[data-chart]').click(function(e) {
                e.preventDefault();
                let p = $(this).data('chart-period');
                let r = $(this).data('chart-resample');
                $('[data-chart]').removeClass('active');
                $(this).addClass('active');
                $.getJSON(`{{ route('pumps.chart.tempMainBearing', $pump->id) }}?period=${p}&resample=${r}`, function(res) {
                    tmbGraphChart.config.data.labels = res.labels;
                    tmbGraphChart.config.data.datasets[0].data = res.data;
                    tmbGraphChart.chart.update();
                });
            });
        })(jQuery);

        var tmbGraphChartCanvas = $('#tempMainBearingChart').get(0).getContext('2d');
        var tmbGraphChart;
        var tmbGraphChartData = {
            labels: [],
            datasets: [{
                label: 'Temp. Main Bearing',
                fill: false,
                borderWidth: 1,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#efefef',
                pointRadius: 0,
                pointHoverRadius: 7,
                pointColor: '#efefef',
                pointBackgroundColor: '#efefef',
                data: []
            }]
        }
        var tmbGraphChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false,
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontColor: '#efefef',
                    },
                    gridLines: {
                        display: false,
                        color: '#efefef',
                        drawBorder: false,
                    }
                }],
                yAxes: [{
                    ticks: {
                        //stepSize: 5000,
                        fontColor: '#efefef',
                    },
                    gridLines: {
                        display: true,
                        color: '#efefef',
                        drawBorder: false,
                    }
                }]
            }
        }
        $.getJSON("{{ route('pumps.chart.tempMainBearing', $pump->id) }}", function(res) {
            tmbGraphChartData.labels = res.labels;
            tmbGraphChartData.datasets[0].data = res.data;
            tmbGraphChart = new Chart(tmbGraphChartCanvas, {
                type: 'line',
                data: tmbGraphChartData,
                options: tmbGraphChartOptions
            })
        });
    </script>
    <script>
        var smGraphChartCanvas = $('#stateMinChart').get(0).getContext('2d');
        var smGraphChart;
        var smGraphChartData = {
            labels: [],
            datasets: [{
                label: 'Running Time',
                fill: true,
                borderWidth: 2,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#efefef',
                pointRadius: 0,
                pointHoverRadius: 7,
                pointColor: '#efefef',
                pointBackgroundColor: '#efefef',
                data: []
            }]
        }
        var smGraphChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false,
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontColor: '#efefef',
                    },
                    gridLines: {
                        display: false,
                        color: '#efefef',
                        drawBorder: false,
                    }
                }],
                yAxes: [{
                    ticks: {
                        //stepSize: 5000,
                        fontColor: '#efefef',
                    },
                    gridLines: {
                        display: true,
                        color: '#efefef',
                        drawBorder: false,
                    }
                }]
            }
        }
        $.getJSON("{{ route('pumps.chart.state', ['pump' => $pump->id, 'period' => '24-hours']) }}", function(res) {
            smGraphChartData.labels = res.labels;
            smGraphChartData.datasets[0].data = res.data;
            smGraphChart = new Chart(smGraphChartCanvas, {
                type: 'bar',
                data: smGraphChartData,
                options: smGraphChartOptions
            })
        });
    </script>
    <script>
        var shGraphChartCanvas = $('#stateHourChart').get(0).getContext('2d');
        var shGraphChart;
        var shGraphChartData = {
            labels: [],
            datasets: [{
                label: 'Running Time',
                fill: true,
                borderWidth: 2,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#efefef',
                pointRadius: 0,
                pointHoverRadius: 7,
                pointColor: '#efefef',
                pointBackgroundColor: '#efefef',
                data: []
            }]
        }
        var shGraphChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false,
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontColor: '#efefef',
                    },
                    gridLines: {
                        display: false,
                        color: '#efefef',
                        drawBorder: false,
                    }
                }],
                yAxes: [{
                    ticks: {
                        //stepSize: 5000,
                        fontColor: '#efefef',
                    },
                    gridLines: {
                        display: true,
                        color: '#efefef',
                        drawBorder: false,
                    }
                }]
            }
        }
        $.getJSON("{!! route('pumps.chart.state', ['pump' => $pump->id, 'period' => 'week', 'resample' => 1440]) !!}", function(res) {
            shGraphChartData.labels = res.labels;
            shGraphChartData.datasets[0].data = res.data;
            shGraphChart = new Chart(shGraphChartCanvas, {
                type: 'bar',
                data: shGraphChartData,
                options: shGraphChartOptions
            })
        });
    </script>
    @endpush