@extends('dashboard.layout')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="mb-3">إرسال لكل العملاء</h5>
                <form method="POST" action="/dashboard/sendToAll">
                    @csrf
                    <div class="mb-3">
                        <label>العنوان</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>النص</label>
                        <textarea name="body" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">إرسال للكل</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="mb-3">إرسال لعميل معين</h5>
                <form method="POST" action="/dashboard/sendToUser">
                    @csrf
                    <div class="mb-3">
                        <label>العميل</label>
                        <select name="user_id" class="form-select">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->mobile }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>العنوان</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>النص</label>
                        <textarea name="body" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">إرسال</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection