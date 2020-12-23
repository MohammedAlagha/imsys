@extends('layouts.dashboard')

@section('title', __('Pumps'))
@section('actions')
    <a href="{{ route('pumps.index') }}" class="btn btn-sm btn-outline-dark">{{ __('Back') }}</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('pumps.store') }}" method="post">
            @include('pumps._form')
        </form>
    </div>
</div>
@endsection