@extends('admin.layouts.app')
@section('title', 'Create Product')
@section('content')
    <div class="card">
        <h3>Create Product</h3>
        <form action="{{ route('products.store') }}" method="post" id="createForm" enctype="multipart/form-data">
            <div>
                @csrf
                <div class="row">
                    <div class="col">
                        <div class=" input-group-static col-5 mb-4">
                            <label>Image</label>
                            <input type="file" accept="image/*" name="image" id="image-input" class="form-control">

                            @error('image')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-5">
                            <img src="" id="show-image" alt="" width="300px">
                        </div>
                    </div>
                    <div class="input-group input-group-static mb-4 col">
                        <label for="name">Name</label>
                        <input type="text" value="{{ old('name') }}" id="name" name="name" class="form-control">

                        @error('name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="input-group input-group-static col mb-4">
                        <label for="price">Price</label>
                        <input id="price" type="number" step="0.1" value="{{ old('price') }}" name="price" class="form-control">
                        @error('price')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-group col input-group-static mb-4">
                        <label for="sale">Sale</label>
                        <input id="sale" type="number" value="0" value="{{ old('sale') }}" name="sale" class="form-control">
                        @error('sale')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="3" rows="3"
                                  style="width: 100%">{{ old('description') }} </textarea>
                        @error('description')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col mb-3">

                        <label for="values" class="form-label">Category</label>
                        <br>
                        <select class="form-control values category_id"  id="values" multiple="multiple" name="category_ids[]">

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>


                        @error('category_ids')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <input type="hidden" id="inputSize" name='sizes'>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddSizeModal">
                    Add size
                </button>

                <!-- Modal -->
                <div class="modal fade" id="AddSizeModal" tabindex="-1" aria-labelledby="AddSizeModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="AddSizeModalLabel">Add size</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="AddSizeModalBody">

                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn  btn-primary btn-add-size">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-submit btn-primary">Submit</button>
        </form>
    </div>
@endsection

@section('style')
    <style>
        .w-40 {
            width: 40%;
        }

        .w-20 {
            width: 20%;
        }

        .row {
            justify-content: center;
            align-items: center
        }

        .ck.ck-editor {
            width: 100%;
            height: 100%;
        }

    </style>
@endsection
@section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"
            integrity="sha512-WFN04846sdKMIP5LKNphMaWzU7YpMyCU245etK3g/2ARYbPK9Ub18eG+ljU96qKRCWh+quCY7yefSmlkQw1ANQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('plugin/ckeditor5-build-classic/ckeditor.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let sizes = [{
            id: Date.now(),
            size: 'M',
            quantity: 1
        }];
    </script>
    <script>
        $(document).ready(function () {
            $("select.category_id").select2({
                tags: true,
                tokenSeparators: [',', ' '],
            }).on('select2:selecting', function(e) {
                // Khi người dùng đang thêm một giá trị mới
                var value = e.params.args.data.id.trim().toLowerCase();

                // Lấy danh sách các giá trị đã được chọn
                var selectedValues = $(this).val() || [];
                selectedValues = selectedValues.map(v => v.trim().toLowerCase());

                // Kiểm tra xem giá trị mới có trùng với bất kỳ giá trị nào đã được chọn chưa
                if (selectedValues.indexOf(value) > -1) {
                    // Nếu giá trị đã tồn tại, hủy bỏ việc thêm giá trị mới
                    e.preventDefault();
                    // Cập nhật lại Select2 để hiển thị đúng giá trị đã chọn
                    $(this).val(selectedValues).trigger('change.select2');
                }
            });
        });
    </script>
    <script src="{{ asset('admin/assets/js/product/product.js') }}"></script>
@endsection
