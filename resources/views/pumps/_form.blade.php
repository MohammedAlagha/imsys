@csrf
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label for="label" class="col-sm-2 col-form-label">{{ __('Label') }}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('label') is-invalid @enderror" name="label" id="label" placeholder="{{ __('Name') }}" value="{{ old('label', $pump->label) }}">
                @error('label')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="station_id" class="col-sm-2 col-form-label">{{ __('Station') }}</label>
            <div class="col-sm-10">
                <select class="form-control @error('station') is-invalid @enderror" name="station_id" id="station_id">
                    @foreach(App\Station::all() as $station)
                    <option value="{{ $station->id }}" @if($station->id == old('station_id', $pump->station_id)) selected @endif>{{ $station->name }}</option>
                    @endforeach
                </select>
                @error('station')
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