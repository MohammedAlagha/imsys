@extends('layouts.dashboard')

@section('title', __('Dashboard'))

@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-6">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tint"></i></span>

            <div class="info-box-content">
                <span class="info-box-text text-muted">{{ __('Total Pumps') }}</span>
                <span class="info-box-number h4">{{ $pumps }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-6">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-industry"></i></span>

            <div class="info-box-content">
                <span class="info-box-text text-muted">{{ __('Stations') }}</span>
                <span class="info-box-number h4">{{ $stations }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <h4 class="h5 text-center">{{ __('Active Pumps') }}</h4>
                        <div class="pt-3">
                            <div class="c100 p{{ ceil(100*($active_pumps/$pumps)) }} center blue">
                                <span><b>{{ $active_pumps }}</b>/{{ $pumps }}</span>
                                <div class="slice">
                                    <div class="bar"></div>
                                    <div class="fill"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="h5 text-center">{{ __('Active Stations') }}</h4>
                        <div class="pt-3">
                            <div class="c100 p{{ ceil(100*($active_stations/$stations)) }} center green">
                                <span><b>{{ $active_stations }}</b>/{{ $stations }}</span>
                                <div class="slice">
                                    <div class="bar"></div>
                                    <div class="fill"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Alerts') }}</h3>

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
                    @forelse($alerts as $alert)
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <strong>{{ $alert->pump->label }}:</strong>
                            {{ $alert->type }}
                            <small class="text-muted">- <time>{{ $alert->created_at->diffForHumans() }}</time></small>
                            <span class="float-right text-{{ $alert->severity }}">
                                <i class="fas fa-exclamation text-sm"></i>
                                {{ $alert->severity }}</span>
                        </a>
                    </li>
                    @empty
                    <li class="nav-item">
                        <span class="nav-link">{{ __('No alerts') }}</span>
                    </li>
                    @endforelse
                </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer bg-white p-0">
            </div>
            <!-- /.footer -->
        </div>
        @if($weather)
        <!-- small box -->
        <div class="small-box bg-light">
            <div class="inner">
                <h3>{{ round($weather['main']['temp']) }} &deg; C</h3>
                <p>{{ $weather['weather'][0]['main'] }}</p>
            </div>
            <div class="icon">
                <i style="background: url(https://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}@2x.png) center; width:55px;height:55px"></i>
            </div>
            <a href="https://openweathermap.org/city/281133" target="_blank" class="small-box-footer">{{ __('More info') }} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        @endif
    </div>
</div>
@endsection


@push('css')
@endpush


@push('js')
@endpush