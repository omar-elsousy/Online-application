@extends('dashboard.layout')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex align-items-center">
                <div class="bg-primary text-white rounded p-3 me-3">
                    <i class="fas fa-box fa-2x"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">إجمالي الأوردرات</h6>
                    <h3 class="mb-0">{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex align-items-center">
                <div class="bg-success text-white rounded p-3 me-3">
                    <i class="fas fa-dollar-sign fa-2x"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">إجمالي المبيعات</h6>
                    <h3 class="mb-0">{{ number_format($totalSales, 1) }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex align-items-center">
                <div class="bg-info text-white rounded p-3 me-3">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">إجمالي العملاء</h6>
                    <h3 class="mb-0">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection