@extends('admin.layout')

@section('content')
<h1 class="h3 mb-3">Edit Feature Flag: {{ $featureFlag->key }}</h1>

<a href="{{ route('admin.feature-flags.index') }}" class="btn btn-link mb-3">
    ← Back to list
</a>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.feature-flags.update', $featureFlag) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name', $featureFlag->name) }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ old('description', $featureFlag->description) }}</textarea>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox"
                       name="enabled"
                       value="1"
                       class="form-check-input"
                       id="enabled"
                       {{ $featureFlag->enabled ? 'checked' : '' }}>
                <label class="form-check-label" for="enabled">Enabled</label>
            </div>

            <div class="mb-3">
                <label class="form-label">Starts at</label>
                <input type="datetime-local"
                       name="starts_at"
                       class="form-control"
                       value="{{ optional($featureFlag->starts_at)->format('Y-m-d\TH:i') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Ends at</label>
                <input type="datetime-local"
                       name="ends_at"
                       class="form-control"
                       value="{{ optional($featureFlag->ends_at)->format('Y-m-d\TH:i') }}">
            </div>

            <button type="submit" class="btn btn-primary">
                Update
            </button>
        </form>
    </div>
</div>
@endsection
