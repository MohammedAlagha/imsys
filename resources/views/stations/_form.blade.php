@csrf
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">{{ __('Name') }}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="{{ __('Name') }}" value="{{ old('name', $station->name) }}">
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="location" class="col-sm-2 col-form-label">{{ __('Location') }}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('location') is-invalid @enderror" name="location" id="location" placeholder="{{ __('Location') }}" value="{{ old('location', $station->location) }}">
                @error('location')
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