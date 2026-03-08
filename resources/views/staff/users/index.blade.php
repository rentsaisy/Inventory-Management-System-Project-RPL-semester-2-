@extends('layouts.app')

@section('title', 'Staff Management')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-users"></i> Staff Management</h1>
        <div class="page-actions">
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Staff
            </a>
        </div>
    </div>

    @if($users->count() > 0)
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge @if($user->role === 'admin') badge-danger @else badge-primary @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge @if($user->status === 'active') badge-success @else badge-danger @endif">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td>
                                {{ $user->last_login ? $user->last_login->format('M d, Y H:i') : 'Never' }}
                            </td>
                            <td>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(auth()->user()->id !== $user->id)
                                    <form method="POST" action="{{ route('users.destroy', $user) }}" style="display: inline;" onsubmit="return confirm('Delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination">
            {{ $users->links() }}
        </div>
    @else
        <div class="card" style="text-align: center; padding: 3rem;">
            <p><i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                No staff members yet. <a href="{{ route('users.create') }}">Add one</a>
            </p>
        </div>
    @endif
</div>
@endsection
