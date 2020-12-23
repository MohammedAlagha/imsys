@extends('layouts.dashboard')

@section('title', (isset($station)? $station->name . ' / ' : '') . __('Pumps'))
@section('actions')
    <a href="{{ route('pumps.create') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-plus"></i> {{ __('Add Pump') }}</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        @include('components.alerts')
        <div class="row">
            @foreach ($pumps as $pump)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $pump->label }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-md-6">{{ __('State') }}:</dt>
                            <dd class="col-md-6 text-right"><span class="d-inline-block px-1 rounded bg-{{ $pump->state? 'success' : 'danger' }}">{{ $pump->state_label }}</span></dd>
                            <dt class="col-md-6">{{ __('Temp. Main Bearing') }}:</dt>
                            <dd class="col-md-6 text-right">{{ $pump->temp_main_bearing }}</dd>
                            <dt class="col-md-6">{{ __('Last Update') }}:</dt>
                            <dd class="col-md-6 text-right">{{ $pump->data_time }}</dd>
                        </dl>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('pumps.show', [$pump->id]) }}" class="btn btn-xs btn-outline-primary"><i class="fas fa-eye"></i> {{ __('View') }}</a>
                        <a href="{{ route('pumps.edit', [$pump->id]) }}" class="btn btn-xs btn-outline-dark"><i class="fas fa-edit"></i> {{ __('Edit') }}</a>
                        <a href="{{ route('pumps.destroy', [$pump->id]) }}" data-toggle="modal" data-target="#actionConfirmModal" data-post-action="delete" data-confirm="{{ __('Are you sure you want to delete this item?') }}" class="btn btn-xs btn-outline-danger"><i class="fas fa-trash"></i> {{ __('Delete') }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $pumps->links() }}
    </div>
</div>
@endsection