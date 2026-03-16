@extends('dashboard.layout')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">تفاصيل الأوردر #{{ $order->id }}</h5>
            <div class="d-flex align-items-center gap-3">
                @if($order->status == 'placed')
                    <span class="badge bg-warning fs-6">placed</span>
                    <form method="POST" action="/dashboard/cancelOrder/{{ $order->id }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('هتلغي الأوردر ده؟')">
                            إلغاء الأوردر
                        </button>
                    </form>
                @elseif($order->status == 'canceled')
                    <span class="badge bg-danger fs-6">canceled</span>
                @endif
            </div>
        </div>

        <div class="mb-3">
            <strong>السعر الكلي:</strong> {{ number_format($order->total_price, 1) }} <br>
            <strong>التاريخ:</strong> {{ $order->created_at }}
        </div>

        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>الضريبة</th>
                    <th>السعر بعد الضريبة</th>
                    <th>الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $item['unit_price'] }}</td>
                    <td>{{ $item['unit_tax'] }}</td>
                    <td>{{ $item['unit_price_after_tax'] }}</td>
                    <td>{{ $item['total_price'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="/dashboard/orders" class="btn btn-secondary mt-2">رجوع</a>
    </div>
</div>
@endsection