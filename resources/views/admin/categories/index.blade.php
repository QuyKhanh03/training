@extends('admin.layouts.app')
@section('title', 'Category')
@section('content')
    <div class="card">

        @if (session('success'))
            <h4 class="text-primary">{{ session('success') }}</h4>
        @endif


        <h3>
            Category list
        </h3>
        <div>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Create</a>

        </div>
        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Parent Name</th>
                    <th>Action</th>
                </tr>

                @foreach ($categories as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>

                        <td>{{ $item->parent_name }}</td>
                        <td>
                                <a href="{{ route('categories.edit', $item->id) }}" class="btn btn-success btn-sm">Edit</a>
                                <form style="display: inline-block" action="{{ route('categories.destroy', $item->id) }}"
                                      id="form-delete{{ $item->id }}" method="post">
                                    @csrf
                                    @method('delete')
                                </form>
                                <button class="btn btn-delete btn-danger btn-sm" data-id={{ $item->id }}>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $categories->links() }}
        </div>

    </div>

@endsection

@section('script')

    <script></script>
@endsection
