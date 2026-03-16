@extends('dashboard.layout')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">العملاء</h5>
            <form method="GET" action="/dashboard/users" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="ابحث برقم الموبايل" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">بحث</button>
            </form>
        </div>

        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>رقم العميل</th>
                    <th>الاسم</th>
                    <th>الموبايل</th>
                    <th>كود العميل </th>
                    <th>أوردرات مكتملة</th>
                    <th>أوردرات ملغية</th>
                    <th>الحالة</th>
                    <th>تاريخ التسجيل</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user['id'] }}</td>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['mobile'] }}</td>
                    <td>{{ $user['pos_code'] }}</td>
                    <td><span class="badge bg-success">{{ $user['placed_orders'] }}</span></td>
                    <td><span class="badge bg-danger">{{ $user['canceled_orders'] }}</span></td>
                    <td>
                        @if($user['is_blocked'])
                            <span class="badge bg-danger">محظور</span>
                        @else
                            <span class="badge bg-success">نشط</span>
                        @endif
                    </td>
                    <td>{{ $user['created_at'] }}</td>
                    <td class="d-flex gap-1">
                        @if($user['is_blocked'])
                            <form method="POST" action="/dashboard/unblockUser/{{ $user['id'] }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">فك الحظر</button>
                            </form>
                        @else
                            <form method="POST" action="/dashboard/blockUser/{{ $user['id'] }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning">حظر</button>
                            </form>
                        @endif
                        <form method="POST" action="/dashboard/deleteUser/{{ $user['id'] }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('هتحذف العميل ده؟')">حذف</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection