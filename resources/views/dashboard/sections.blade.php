@extends('dashboard.layout')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="mb-4">الاعلانات</h5>
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>الصورة</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
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
                        <form method="POST" action="/dashboard/updateSortOrder/{{ $section->id }}" class="d-flex gap-2">
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
                        <form method="POST" action="/dashboard/toggleSection/{{ $section->id }}">
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
@endsection