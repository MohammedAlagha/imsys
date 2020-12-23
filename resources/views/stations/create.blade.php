@extends('layouts.dashboard')

@section('title', __('Stations'))
@section('actions')
    <a href="{{ route('stations.index') }}" class="btn btn-sm btn-outline-dark">{{ __('Back') }}</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('stations.store') }}" method="post">
            @include('stations._form')
        </form>
    </div>
</div>
@endsection