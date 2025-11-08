{{-- resources/views/home.blade.php --}}
@section('title', '販売管理ダッシュボード')

<x-app-layout>
    {{-- 上部ヘッダー（ナビの下に出るタイトル行） --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('販売管理システム ダッシュボード') }}
        </h2>
    </x-slot>

    {{-- メインコンテンツ --}}
    <div class="py-6">
        <div class="container mt-5">
            <h1 class="mb-4 text-center">販売管理システム　ダッシュボード</h1>

            {{-- サマリー --}}
            <div class="row mb-4 text-center">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">登録商品数</h5>
                            <p class="display-6 fw-bold text-primary">{{ $productCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">受注件数</h5>
                            <p class="display-6 fw-bold text-success">{{ $orderCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">全体在庫数</h5>
                            <p class="display-6 fw-bold text-warning">{{ $totalStock ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- メニュー一覧 --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <a href="{{ route('products.index') }}" class="btn btn-lg btn-outline-primary w-100">商品マスタ</a>
                </div>
                <div class="col-md-6 mb-3">
                    {{-- <a href="{{ route('partners.index') }}" class="btn btn-lg btn-outline-secondary w-100">取引先マスタ</a> --}}
                </div>
                <div class="col-md-6 mb-3">
                    {{-- <a href="{{ route('sales-orders.index') }}" class="btn btn-lg btn-outline-success w-100">受注管理</a> --}}
                </div>
                <div class="col-md-6 mb-3">
                    {{-- <a href="{{ route('purchase-orders.index') }}" class="btn btn-lg btn-outline-info w-100">発注管理</a> --}}
                </div>
                <div class="col-md-6 mb-3">
                    {{-- <a href="{{ route('stocks.index') }}" class="btn btn-lg btn-outline-warning w-100">在庫一覧</a> --}}
                </div>
                <div class="col-md-6 mb-3">
                    {{-- <a href="{{ route('invoices.index') }}" class="btn btn-lg btn-outline-dark w-100">請求書一覧</a> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
