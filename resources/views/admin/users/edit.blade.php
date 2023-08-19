@extends('admin.layouts.app')
@section('title', 'Create User')
@section('content')
    <div class="card">
        <h3>Update User</h3>
        <div>
            <form action="{{ route('users.update',$user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <div class=" input-group-static col-5 mb-4">
                                <label>Image</label>
                                <input type="file" accept="image/*" name="image" id="image-input"  class="form-control">

                                @error('image')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-5">
                                <img src="{{ asset('upload/users/'. $user_img->url) }}" id="show-image" width="100px" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <div class="input-group input-group-static mb-4">
                                <label>Name</label>
                                <input type="text" value="{{ old('name') ?? $user->name  }}" name="name" class="form-control">

                                @error('name')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <div class="input-group input-group-static mb-4">
                                <label>Email</label>
                                <input type="email" value="{{ old('email') ?? $user->email }}" name="email" class="form-control">
                                @error('email')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <div class="input-group input-group-static mb-4">
                                <label>Phone</label>
                                <input type="text" value="{{ old('phone') ?? $user->phone }}" name="phone" class="form-control">
                                @error('phone')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <div class="input-group input-group-static mb-4 pt-4">
                                <label  class="ms-0">Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="male">Male</option>
                                    <option value="fe-male">FeMale</option>
                                </select>

                                @error('gender')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <div class="input-group input-group-static mb-4">
                                <label>Address</label>
                                <textarea name="address" class="form-control"> {{ old('address') ?? $user->address }} </textarea>
                                @error('address')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <div class="input-group input-group-static mb-4">
                                <label>Password</label>
                                <input type="password" value="{{ old('password') ?? $user->password }}" name="password" class="form-control">
                                @error('password')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="">Roles</label>
                                <div class="row">
                                    @foreach ($roles as $groupName => $role)
                                        <div class="col-5">
                                            <div class="d-flex">
                                                @foreach ($role as $key => $value)
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="role_ids[]" type="checkbox"
                                                               value="{{ $value->id }}"
                                                               id="{{ $value->id }}"
                                                                @foreach ($user->roles as $role)
                                                                    {{ $role->id == $value->id ? 'checked' : '' }}
                                                                @endforeach
                                                        >
                                                        <label class="custom-control-label"
                                                               for="{{ $value->id }}">{{ $value->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                    @error('role_ids')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>









                <button type="submit" class="btn btn-submit btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection


@section('script')

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>
    <script>
        $(() => {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#show-image').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image-input").change(function() {
                readURL(this);
            });



        });
    </script>
@endsection
