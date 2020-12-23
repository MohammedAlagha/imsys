@extends('layouts.dashboard')

@section('title', __('Stations'))
@section('actions')
<a href="{{ route('stations.create') }}" class="btn btn-sm btn-outline-primary">{{ __('Add Station') }}</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        @include('components.alerts')
        <div class="row">
            @forelse($stations as $station)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $station->name }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <strong>{{ __('Active Pumps') }}:</strong>
                                <span class="float-right text-info">{{ $station->pumps_count }}</span>
                            </li>
                            <li class="nav-item">
                                <strong>{{ __('Location') }}:</strong>
                                <span class="float-right text-info">{{ $station->location }}</span>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <a href="{{ route('stations.pumps', [$station->id]) }}" class="btn btn-xs btn-outline-success"><i class="fas fa-edit"></i> {{ __('View') }}</a>
                        <a href="{{ route('stations.edit', [$station->id]) }}" class="btn btn-xs btn-outline-primary"><i class="fas fa-edit"></i> {{ __('Edit') }}</a>
                        <a href="{{ route('stations.destroy', [$station->id]) }}" data-toggle="modal" data-target="#actionConfirmModal" data-post-action="delete" data-confirm="{{ __('Are you sure you want to delete this item?') }}" class="btn btn-xs btn-outline-danger"><i class="fas fa-trash"></i> {{ __('Delete') }}</a>
                    </div>
                    <!-- /.footer -->
                </div>
            </div>
            @empty
            @endforelse
        </div>
        {{ $stations->links() }}
    </div>
</div>
@endsection