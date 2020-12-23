@extends('layouts.dashboard')

@section('title', __('Change Password'))

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('users.password') }}" method="post">
            <div class="card">
                <div class="card-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">{{ __('Current Password') }}</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="{{ __('Password') }}">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="new_password" class="col-sm-3 col-form-label">{{ __('New Password') }}</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" id="new_password" placeholder="{{ __('New Password') }}">
                            @error('new_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="new_password_confirmation" class="col-sm-3 col-form-label">{{ __('New Password Confirmation') }}</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" id="new_password_confirmation" placeholder="{{ __('Confirm New Password') }}">
                            @error('new_password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection