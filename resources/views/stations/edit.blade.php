@extends('layouts.dashboard')

@section('title', __('Edit Station :name', ['name' => $station->name]))
@section('actions')
    <a href="{{ route('stations.index') }}" class="btn btn-sm btn-outline-dark">{{ __('Back') }}</a>
    <a href="{{ route('stations.create') }}" class="btn btn-sm btn-outline-primary">{{ __('Add Station') }}</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('stations.update', [$station->id]) }}" method="post">
            @method('PUT')
            @include('stations._form')
        </form>
    </div>
</div>
@endsection