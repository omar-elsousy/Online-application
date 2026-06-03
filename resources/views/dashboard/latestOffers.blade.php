@extends('dashboard.layout')

@section('content')

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="mb-3">إضافة منتج للعروض</h5>
                <form method="POST" action="{{ asset('dashboard/addLatestOffer') }}">
                    @csrf
                    <div class="mb-3">
                        <label>ابحث عن منتج</label>
                        <input type="text" id="searchProduct" class="form-control mb-2" placeholder="ابحث بالكود أو الاسم">
                        <select name="product_id" id="productSelect" class="form-select" size="5">
                            @foreach($products as $product)
                                <option value="{{ $product->product_id }}"
                                    data-name="{{ strtolower($product->product_ename) }}"
                                    data-id="{{ $product->product_id }}">
                                    {{ $product->product_id }} - {{ $product->product_ename }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">إضافة</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="mb-3">المنتجات المعروضة</h5>
                <div class="mb-3">
                    <input type="text" id="searchOffers" class="form-control" placeholder="ابحث عن منتج">
                </div>
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>كود المنتج</th>
                            <th>المنتج</th>
                            <th>حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offers as $offer)
                        <tr>
                            <td>{{ $offer['product_id'] }}</td>
                            <td>{{ $offer['name'] }}</td>
                            <td>
                                <form method="POST" action="{{ asset('dashboard/removeLatestOffer/' . $offer['product_id']) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('هتحذف المنتج ده من العروض؟')">حذف</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('searchProduct').addEventListener('keyup', function() {
        let search = this.value.toLowerCase();
        document.querySelectorAll('#productSelect option').forEach(function(option) {
            let name = option.getAttribute('data-name');
            let id = option.getAttribute('data-id');
            option.style.display = (name.includes(search) || id.includes(search)) ? '' : 'none';
        });
    });

    document.getElementById('searchOffers').addEventListener('keyup', function() {
        let search = this.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(function(row) {
            let name = row.cells[1].textContent.toLowerCase();
            let id = row.cells[0].textContent.toLowerCase();
            row.style.display = (name.includes(search) || id.includes(search)) ? '' : 'none';
        });
    });
</script>

@endsection