@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')
    <div class="card">

        <h1>
            User list
        </h1>
        @if (session('message'))
            <h1 class="text-primary">{{ session('message') }}</h1>
        @endif
        <div>
            <a href="{{ route('users.create') }}" class="btn btn-primary">Create</a>

        </div>
        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>

                @if(isset($users))
                    @foreach ($users as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td><img src="{{ asset('upload/'.$item->image_path) }}" width="200px" height="200px" alt=""></td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>
                                <a href="{{ route('users.edit', $item->id) }}" class="btn btn-sm btn-success">Edit</a>
                                <form action="{{ route('users.destroy', $item->id) }}" id="form-delete{{ $item->id }}"
                                      method="post" style="display: inline-block">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-delete btn-danger" type="submit"
                                            data-id={{ $item->id }}>Delete</button>

                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">No data</td>
                    </tr>
                @endif
            </table>
            @if(isset($users))
                {{ $users->links() }}
            @endif
        </div>

    </div>

@endsection

@section('script')
@endsection
