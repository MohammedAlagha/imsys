@extends('layouts.dashboard')

@section('title', __('Edit User :label', ['label' => $user->label]))
@section('actions')
    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-dark">{{ __('Back') }}</a>
    <a href="{{ route('users.create') }}" class="btn btn-sm btn-outline-primary">{{ __('Add User') }}</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('users.update', [$user->id]) }}" method="post">
            @method('PUT')
            @include('users._form')
        </form>
    </div>
</div>
@endsection