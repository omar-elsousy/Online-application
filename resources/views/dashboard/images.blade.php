@extends('dashboard.layout')

@section('content')

<ul class="nav nav-tabs mb-4" id="imageTabs">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#products">صور المنتجات</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#categories">صور الكاتيجوريز</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#sections">صور الإعلانات</a>
    </li>
</ul>

<div class="tab-content">

    {{-- صور المنتجات --}}
    <div class="tab-pane fade show active" id="products">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h6 class="mb-3">رفع صورة منتج</h6>
                <form method="POST" action="/dashboard/uploadProductImage" enctype="multipart/form-data" class="d-flex gap-2 align-items-end">
                    @csrf
                    <div>
                        <label>المنتج</label>
                        <select name="product_id" class="form-select">
                            @foreach($products as $product)
                                <option value="{{ $product->product_id }}">{{ $product->product_ename }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>الصورة</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">رفع</button>
                </form>
            </div>
        </div>
        <div class="row">
            @foreach($productImages as $image)
            <div class="col-md-2 mb-3">
                <div class="card border-0 shadow-sm">
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" style="height:120px;object-fit:cover;">
                    <div class="card-body p-2 text-center">
                        <small>{{ $image->name }}</small>
                        <br>
                        <small>code : {{ $image->ref_id }}</small>
                        <form method="POST" action="/dashboard/deleteImage/{{ $image->id }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger w-100 mt-1"
                                onclick="return confirm('هتحذف الصورة دي؟')">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- صور الكاتيجوريز --}}
    <div class="tab-pane fade" id="categories">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h6 class="mb-3">رفع صورة كاتيجوري</h6>
                <form method="POST" action="/dashboard/uploadCategoryImage" enctype="multipart/form-data" class="d-flex gap-2 align-items-end">
                    @csrf
                    <div>
                        <label>الكاتيجوري</label>
                        <select name="family_id" class="form-select">
                            @foreach($categories as $category)
                                <option value="{{ $category->family_id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>الصورة</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">رفع</button>
                </form>
            </div>
        </div>
        <div class="row">
            @foreach($categoryImages as $image)
            <div class="col-md-2 mb-3">
                <div class="card border-0 shadow-sm">
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" style="height:120px;object-fit:cover;">
                    <div class="card-body p-2 text-center">
                        <small>{{ $image->name }}</small>
                        <br>
                        <small>code : {{ $image->ref_id }}</small>   
                        <form method="POST" action="/dashboard/deleteImage/{{ $image->id }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger w-100 mt-1"
                                onclick="return confirm('هتحذف الصورة دي؟')">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- صور السكشنز --}}
    <div class="tab-pane fade" id="sections">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h6 class="mb-3">رفع صورة إعلان</h6>
                <form method="POST" action="/dashboard/uploadSectionImage" enctype="multipart/form-data" class="d-flex gap-2 align-items-end">
                    @csrf
                    <div>
                        <label>الصورة</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">رفع</button>
                </form>
            </div>
        </div>
        <div class="row">
            @foreach($sectionImages as $image)
            <div class="col-md-2 mb-3">
                <div class="card border-0 shadow-sm">
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" style="height:120px;object-fit:cover;">
                    <div class="card-body p-2 text-center">
                        <form method="POST" action="/dashboard/deleteImage/{{ $image->id }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger w-100 mt-1"
                                onclick="return confirm('هتحذف الصورة دي؟')">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

@endsection