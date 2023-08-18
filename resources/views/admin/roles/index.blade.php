@extends('admin.layouts.app')
@section('title', 'Roles')
@section('content')
    <div class="card">

        @if (session('success'))
            <h3 class="text-primary">{{ session('success') }}</h3>
        @endif


        <h3>
            Role list
        </h3>
        <div>
            <a href="{{ route('roles.create') }}" class="btn btn-primary">Create</a>

        </div>
        <div>
            <table class="table table-hover table-bordered">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>DisplayName</th>
                    <th>Action</th>
                </tr>

                @if(isset($roles))
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>

                            <td>{{ $role->display_name }}</td>
                            <td>
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-success">Edit</a>

                                <form style="display: inline-block" action="{{ route('roles.destroy', $role->id) }}" id="form-delete{{ $role->id }}"
                                      method="post">
                                    @csrf
                                    @method('delete')

                                </form>

                                <button class="btn btn-delete btn-sm btn-danger" data-id={{ $role->id }}>Delete</button>

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">No data</td>
                    </tr>
                @endif
            </table>
            @if(isset($roles))
                {{ $roles->links() }}
            @endif

        </div>

    </div>

@endsection
