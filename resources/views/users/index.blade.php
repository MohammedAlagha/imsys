@extends('layouts.dashboard')

@section('title', __('Users'))
@section('actions')
    <a href="{{ route('users.create') }}" class="btn btn-sm btn-outline-primary">{{ __('Add User') }}</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        @include('components.alerts')
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Created At') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        <a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-sm btn-outline-primary">{{ __('Edit') }}</a>
                        <a href="{{ route('users.password', [$user->id]) }}" class="btn btn-sm btn-outline-success">{{ __('Change Password') }}</a>
                        <a href="{{ route('users.destroy', [$user->id]) }}" data-toggle="modal" data-target="#actionConfirmModal" data-post-action="delete" data-confirm="{{ __('Are you sure you want to delete this item?') }}" class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">{{ __('No entries!') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection