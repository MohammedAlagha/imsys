@extends('layouts.dashboard')

@section('title', __('Edit Pump :label', ['label' => $pump->label]))
@section('actions')
    <a href="{{ route('pumps.index') }}" class="btn btn-sm btn-outline-dark">{{ __('Back') }}</a>
    <a href="{{ route('pumps.create') }}" class="btn btn-sm btn-outline-primary">{{ __('Add Pump') }}</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('pumps.update', [$pump->id]) }}" method="post">
            @method('PUT')
            @include('pumps._form')
        </form>
    </div>
</div>
@endsection