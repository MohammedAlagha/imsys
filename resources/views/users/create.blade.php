@extends('layouts.dashboard')

@section('title', __('Users'))
@section('actions')
    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-dark">{{ __('Back') }}</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('users.store') }}" method="post">
            @include('users._form')
        </form>
    </div>
</div>
@endsection