@extends('dashboard.layout')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="mb-4">السكشنز</h5>
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>الصورة</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
                    <th>الأكشن</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sections as $section)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $section->image_path) }}"
                            style="height:60px;width:100px;object-fit:cover;border-radius:6px;">
                    </td>

                    <td>
                        <form method="POST" action="{{ url('dashboard/updateSortOrder/' . $section->id) }}" class="d-flex gap-2">
                            @csrf
                            <input type="number" name="sort_order" value="{{ $section->sort_order }}"
                                class="form-control form-control-sm" style="width:80px;">
                            <button type="submit" class="btn btn-sm btn-secondary">حفظ</button>
                        </form>
                    </td>

                    <td>
                        @if($section->is_active_section)
                        <span class="badge bg-success">نشط</span>
                        @else
                        <span class="badge bg-danger">معطل</span>
                        @endif
                    </td>

                    <td>
                        <form method="POST" action="{{ url('dashboard/updateAction/' . $section->id) }}" class="d-flex gap-2 align-items-end flex-wrap">
                            @csrf
                            <div>
                                <select name="action_type" class="form-select form-select-sm action-type-select" onchange="toggleActionId(this, '{{ $section->id }}')">
                                    <option value="none" {{ $section->action_type == 'none' ? 'selected' : '' }}>بدون أكشن</option>
                                    <option value="product" {{ $section->action_type == 'product' ? 'selected' : '' }}>منتج</option>
                                    <option value="category" {{ $section->action_type == 'category' ? 'selected' : '' }}>كاتيجوري</option>
                                </select>
                            </div>

                            <div id="action_id_wrapper_{{ $section->id }}" @style(['display: none'=> $section->action_type == 'none'])>

                                <select id="category_select_{{ $section->id }}"
                                    name="{{ $section->action_type == 'category' ? 'action_id' : '' }}"
                                    class="form-select form-select-sm"
                                    @style(['display: none'=> $section->action_type != 'category'])>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->family_id }}" {{ $section->action_id == $category->family_id ? 'selected' : '' }}>
                                        {{ $category->family_id }} - {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>

                                <select id="product_select_{{ $section->id }}"
                                    name="{{ $section->action_type == 'product' ? 'action_id' : '' }}"
                                    class="form-select form-select-sm"
                                    @style(['display: none'=> $section->action_type != 'product'])>
                                    @foreach($products as $product)
                                    <option value="{{ $product->product_id }}" {{ $section->action_id == $product->product_id ? 'selected' : '' }}>
                                        {{ $product->product_id }} - {{ $product->product_ename }}
                                    </option>
                                    @endforeach
                                </select>

                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">حفظ</button>
                        </form>
                    </td>

                    <td>
                        <form method="POST" action="{{ url('dashboard/toggleSection/' . $section->id) }}">
                            @csrf
                            @if($section->is_active_section)
                            <button type="submit" class="btn btn-sm btn-warning">تعطيل</button>
                            @else
                            <button type="submit" class="btn btn-sm btn-success">تفعيل</button>
                            @endif
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleActionId(select, sectionId) {
        let wrapper = document.getElementById('action_id_wrapper_' + sectionId);
        let categorySelect = document.getElementById('category_select_' + sectionId);
        let productSelect = document.getElementById('product_select_' + sectionId);

        let value = select.value;

        if (value === 'none') {
            wrapper.style.display = 'none';
            categorySelect.removeAttribute('name');
            productSelect.removeAttribute('name');
        } else if (value === 'category') {
            wrapper.style.display = '';
            categorySelect.style.display = '';
            productSelect.style.display = 'none';

            // نحدد مين الـ select اللي هتبعت البيانات للسيرفر
            categorySelect.setAttribute('name', 'action_id');
            productSelect.removeAttribute('name');
        } else if (value === 'product') {
            wrapper.style.display = '';
            categorySelect.style.display = 'none';
            productSelect.style.display = '';

            // نحدد مين الـ select اللي هتبعت البيانات للسيرفر
            productSelect.setAttribute('name', 'action_id');
            categorySelect.removeAttribute('name');
        }
    }
</script>
@endsection