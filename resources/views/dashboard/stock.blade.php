@extends('dashboard.layout')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="mb-4">الستوك</h5>

        <form method="GET" action="/dashboard/stock" class="row g-2 mb-4">
            <div class="col-md-4">
                <select name="warehouse_id" class="form-select" onchange="this.form.submit()">
                    <option value="">اختر مخزن</option>
                    @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->warehouse_id }}"
                            {{ $selectedWarehouse == $warehouse->warehouse_id ? 'selected' : '' }}>
                            {{ $warehouse->warehouse_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if($selectedWarehouse)
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                    placeholder="ابحث عن منتج" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">بحث</button>
            </div>
            @endif
        </form>

        @if($selectedWarehouse)
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>رقم المنتج</th>
                    <th>اسم المنتج</th>
                    <th>الحالة</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product['product_id'] }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>
                        @if($product['in_stock'])
                            <span class="badge bg-success">In Stock</span>
                        @else
                            <span class="badge bg-danger">Out of Stock</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="/dashboard/toggleStock/{{ $product['product_id'] }}/{{ $product['warehouse_id'] }}">
                            @csrf
                            @if($product['in_stock'])
                                <button type="submit" class="btn btn-sm btn-danger">غلق</button>
                            @else
                                <button type="submit" class="btn btn-sm btn-success">فتح</button>
                            @endif
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div class="alert alert-info">اختر مخزن عشان تشوف الستوك</div>
        @endif
    </div>
</div>
@endsection