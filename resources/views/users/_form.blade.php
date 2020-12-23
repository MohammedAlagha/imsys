@csrf
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">{{ __('Name') }}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="{{ __('Name') }}" value="{{ old('name', $user->name) }}">
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">{{ __('Email Address') }}</label>
            <div class="col-sm-10">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="{{ __('Email Address') }}" value="{{ old('email', $user->email) }}">
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        @if(!$user->id)
        <div class="form-group row">
            <label for="password" class="col-sm-2 col-form-label">{{ __('Password') }}</label>
            <div class="col-sm-10">
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="{{ __('Password') }}">
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="password_confirmation" class="col-sm-2 col-form-label">{{ __('Password Confirmation') }}</label>
            <div class="col-sm-10">
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="{{ __('Confirm Password') }}">
                @error('password_confirmation')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        @endif
    </div>
    <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    </div>
</div>