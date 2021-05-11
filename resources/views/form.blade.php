@extends('layout')

@section('content')
    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <input class="form-control" name="file" type="file" id="formFile" required>
            @error('file')
                <div class="block w-full text-red-600">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-check form-switch">
            <label for="formFile" class="form-label">Private</label>
            <input class="form-check-input" @if(old('is_private')) checked @endif name="is_private" type="checkbox" id="flexSwitchCheckDefault">
            @error('is_private')
                <div class="block w-full text-red-600">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>
@endsection




