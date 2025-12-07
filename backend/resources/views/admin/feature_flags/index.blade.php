@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Feature Flags</h1>
    <a href="{{ route('admin.feature-flags.create') }}" class="btn btn-primary">
        Create new flag
    </a>
</div>

<table class="table table-bordered table-striped bg-white">
    <thead class="table-light">
        <tr>
            <th>Key</th>
            <th>Name</th>
            <th>Enabled</th>
            <th>Starts at</th>
            <th>Ends at</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse($flags as $flag)
        <tr>
            <td>{{ $flag->key }}</td>
            <td>{{ $flag->name }}</td>
            <td>
                @if($flag->enabled)
                    <span class="badge bg-success">Yes</span>
                @else
                    <span class="badge bg-secondary">No</span>
                @endif
            </td>
            <td>{{ $flag->starts_at ?? '-' }}</td>
            <td>{{ $flag->ends_at ?? '-' }}</td>
            <td class="d-flex gap-2">
                <a href="{{ route('admin.feature-flags.edit', $flag) }}" class="btn btn-sm btn-outline-primary">
                    Edit
                </a>

                <form action="{{ route('admin.feature-flags.destroy', $flag) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this flag?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">
                No feature flags found.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
