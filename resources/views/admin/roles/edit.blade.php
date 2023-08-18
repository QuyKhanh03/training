@extends('admin.layouts.app')
@section('title', 'Update Roles '. $role->name)
@section('content')
    <div class="card">
        <div class="row">
            <div class="col">
                <h3>Update role : {{ $role->name }}</h3>

            </div>
            <div class="col">
                <a href="{{ route('roles.index') }}" class="btn btn-primary float-end">Back</a>
            </div>
        </div>

        <div>
            <form action="{{ route('roles.update',$role->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col">
                        <div class="input-group input-group-static mb-4 pt-4">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" value="{{ old('name') ?? $role->name }}" id="name" name="name" class="form-control">
                            @error('name')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group input-group-static mb-4 pt-4">
                            <label class="form-label" for="display_name">Display Name</label>
                            <input type="text" value="{{ old('display_name') ?? $role->display_name }}" id="display_name" name="display_name" class="form-control">
                            @error('display_name')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group input-group-static mb-4 ">
                            <label  for="group" class="form-label ">Group</label>
                            <select  id="group" name="group" class="form-control mt-4">
                                <option value="">Select group</option>
                                <option {{ $role->group == "system" ? "selected" : "" }} value="system">System</option>
                                <option {{ $role->group == "user" ? "selected" : "" }} value="user">User</option>
                            </select>

                            @error('group')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Permission</label>
                    <div class="row">
                        @foreach ($permissions as $groupName => $permission)
                            <div class="col-5">
                                <h5>{{ $groupName }}</h5>
                                <div>
                                    @foreach ($permission as $item)
                                        <div class="form-check">
                                            <input  id="{{ $item->id }}" class="form-check-input" name="permission_ids[]" type="checkbox"
                                                    {{ $role->permissions->contains('name', $item->name) ? 'checked' : '' }}
                                                   value="{{ $item->id }}">
                                            <label class="custom-control-label"
                                                   for="{{ $item->id }}">{{ $item->display_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-submit btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
