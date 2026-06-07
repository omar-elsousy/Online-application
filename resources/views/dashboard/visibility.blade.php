@extends('dashboard.layout')

@section('content')

<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#products">المنتجات</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#categories">الكاتيجوريز</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#companies">الشركات</a>
    </li>
</ul>

<div class="tab-content">

    {{-- المنتجات --}}
    <div class="tab-pane fade show active" id="products">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" id="searchProducts" class="form-control" placeholder="ابحث عن منتج">
                </div>
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>كود المنتج</th>
                            <th>المنتج</th>
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
                                @if($product['is_hidden'])
                                <span class="badge bg-danger">مخفي</span>
                                @else
                                <span class="badge bg-success">ظاهر</span>
                                @endif
                            </td>
                            <td>
                                @if($product['is_hidden'])
                                <form method="POST" action="{{ asset('dashboard/showProduct') }}/{{ $product['product_id'] }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">إظهار</button>
                                </form>
                                @else
                                <form method="POST" action="{{ asset('dashboard/hideProduct') }}/{{ $product['product_id'] }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">إخفاء</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- الكاتيجوريز --}}
    <div class="tab-pane fade" id="categories">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" id="searchCategories" class="form-control" placeholder="ابحث عن كاتيجوري">
                </div>
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>رقم الكاتيجوري</th>
                            <th>الكاتيجوري</th>
                            <th>الحالة</th>
                            <th>إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category['family_id'] }}</td>
                            <td>{{ $category['name'] }}</td>
                            <td>
                                @if($category['is_hidden'])
                                <span class="badge bg-danger">مخفي</span>
                                @else
                                <span class="badge bg-success">ظاهر</span>
                                @endif
                            </td>
                            <td>
                                @if($category['is_hidden'])
                                <form method="POST" action="{{ asset('dashboard/showCategory') }}/{{ $category['family_id'] }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">إظهار</button>
                                </form>
                                @else
                                <form method="POST" action="{{ asset('dashboard/hideCategory') }}/{{ $category['family_id'] }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">إخفاء</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- الشركات --}}
    <div class="tab-pane fade" id="companies">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" id="searchCompanies" class="form-control" placeholder="ابحث عن شركة">
                </div>
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>رقم الشركة</th>
                            <th>الشركة</th>
                            <th>الحالة</th>
                            <th>إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                        <tr>
                            <td>{{ $company['company_id'] }}</td>
                            <td>{{ $company['name'] }}</td>
                            <td>
                                @if($company['is_hidden'])
                                <span class="badge bg-danger">مخفي</span>
                                @else
                                <span class="badge bg-success">ظاهر</span>
                                @endif
                            </td>
                            <td>
                                @if($company['is_hidden'])
                                <form method="POST" action="{{ asset('dashboard/showCompany/' . $company['company_id']) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">إظهار</button>
                                </form>
                                @else
                                <form method="POST" action="{{ asset('dashboard/hideCompany/' . $company['company_id']) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">إخفاء</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>

<script>
    // سيرش المنتجات
    document.getElementById('searchProducts').addEventListener('keyup', function() {
        let search = this.value.toLowerCase();
        document.querySelectorAll('#products tbody tr').forEach(function(row) {
            // كود المنتج موجود في الخلية رقم 0 (العمود الأول)
            let id = row.cells[0].textContent.toLowerCase();
            // اسم المنتج موجود في الخلية رقم 1 (العمود الثاني)
            let name = row.cells[1].textContent.toLowerCase();

            // لو البحث موجود في الـ id أو الـ name أظهر الصف
            row.style.display = (id.includes(search) || name.includes(search)) ? '' : 'none';
        });
    });

    // سيرش الكاتيجوريز
    document.getElementById('searchCategories').addEventListener('keyup', function() {
        let search = this.value.toLowerCase();
        document.querySelectorAll('#categories tbody tr').forEach(function(row) {
            // رقم الكاتيجوري في الخلية رقم 0
            let id = row.cells[0].textContent.toLowerCase();
            // اسم الكاتيجوري في الخلية رقم 1
            let name = row.cells[1].textContent.toLowerCase();

            // لو البحث موجود في الـ id أو الـ name أظهر الصف
            row.style.display = (id.includes(search) || name.includes(search)) ? '' : 'none';
        });
    });

    // سيرش الشركات
    document.getElementById('searchCompanies').addEventListener('keyup', function() {
        let search = this.value.toLowerCase();
        document.querySelectorAll('#companies tbody tr').forEach(function(row) {
            // رقم الشركة في الخلية رقم 0
            let id = row.cells[0].textContent.toLowerCase();
            // اسم الشركة في الخلية رقم 1
            let name = row.cells[1].textContent.toLowerCase();

            // لو البحث موجود في الـ id أو الـ name أظهر الصف
            row.style.display = (id.includes(search) || name.includes(search)) ? '' : 'none';
        });
    });
</script>

@endsection