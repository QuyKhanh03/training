@extends('admin.layouts.app')
@section('title', 'orders')
@section('content')

    <div class="card">

        <h1>
            Orders
        </h1>
        <div class="container-fluid pt-5">

            <div class="col card">
                <div>
                    <table class="table table-hover">
                        <tr>
                            <th>#</th>
                            <th>status</th>
                            <th>total</th>
                            <th>ship</th>
                            <th>customer name</th>
                            <th>customer email</th>
                            <th>customer address</th>
                            <th>note</th>
                            <th>payment</th>
                        </tr>

                        @foreach ($orders as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>

                                    <div class="input-group input-group-static mb-4">
{{--                                        {{ $item->status }}--}}
                                        <select name="status" class="form-control select-status"
                                                data-action="{{ route('admin.orders.update_status', $item->id) }}">
                                            @foreach (config('order.status') as $status)
                                                <option value="{{ $status }}"
                                                    {{ $status == $item->status ? 'selected' : '' }}>{{ $status }}
                                                </option>
                                            @endforeach
                                        </select>

                                </td>
                                <td>${{ $item->total }}</td>

                                <td>${{ $item->ship }}</td>
                                <td>{{ $item->customer_name }}</td>
                                <td>{{ $item->customer_email }}</td>

                                <td>{{ $item->customer_address }}</td>
                                <td>{{ $item->note }}</td>
                                <td>{{ 'Tiền mặt' }}</td>

                            </tr>
                        @endforeach
                    </table>
                    {{ $orders->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('admin/assets/order/order.js') }}"></script>
@endsection
