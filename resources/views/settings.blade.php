@extends('layouts.dashboard')

@section('title', __('Settings'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Settings') }}</h3>
            </div>
            <div class="card-body">
                @include('components.alerts')
                <form action="{{ route('settings') }}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-md-3 text-md-right" for="thresholds">{{ __('Thresholds') }}</label>
                        <div class="col-md-9">
                            <textarea name="thresholds" class="form-control" rows="5">{{ $settings['thresholds'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </form>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
</div>
@endsection
