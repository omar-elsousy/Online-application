@extends('dashboard.layout')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="mb-3">إضافة أدمن جديد</h5>

                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ asset('dashboard/addAdmin') }}">
                    @csrf
                    <div class="mb-3">
                        <label>رقم الموبايل</label>
                        <input type="text" name="mobile" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>كلمة المرور</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">إضافة</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="mb-3">الأدمنز</h5>
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>رقم الادمن</th>
                            <th>الموبايل</th>
                            <th>الصلاحية</th>
                            <th>تاريخ الإضافة</th>
                            <th>حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->mobile }}</td>
                            <td>
                                @if($admin->role == 'super_admin')
                                    <span class="badge bg-danger">Super Admin</span>
                                @else
                                    <span class="badge bg-primary">Admin</span>
                                @endif
                            </td>
                            <td>{{ $admin->created_at }}</td>
                            <td>
                                @if($admin->id != session('admin_id') && $admin->role != 'super_admin')
                                    <form method="POST" action="{{ asset('dashboard/deleteAdmin') }}/{{ $admin->id }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('هتحذف الأدمن ده؟')">حذف</button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
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
@endsection