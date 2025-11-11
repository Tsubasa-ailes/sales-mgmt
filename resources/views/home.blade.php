{{-- resources/views/home.blade.php --}}
@section('title', '販売管理ダッシュボード')

<x-app-layout>
    {{-- 上部ヘッダー --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('販売管理システム ダッシュボード') }}
        </h2>
    </x-slot>

    {{-- ログイン済ユーザー向けコンテンツ --}}
    @auth
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
                        <a href="{{ route('products.index') }}" class="btn btn-lg btn-outline-primary w-100">商品一覧</a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('products.create') }}" class="btn btn-lg btn-outline-primary w-100">商品登録</a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('partners.index') }}" class="btn btn-lg btn-outline-primary w-100">取引先マスタ</a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('sales_orders.create') }}" class="btn btn-lg btn-outline-primary w-100">受注登録</a>
                    </div>
                    {{-- 以下は未実装ボタン --}}
                    {{-- ... --}}
                    @if (auth()->user()->role == 1)
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('users.index') }}" class="btn btn-lg btn-outline-primary w-100">ユーザー一覧</a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('users.create') }}" class="btn btn-lg btn-outline-primary w-100">ユーザー追加</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endauth

    {{-- 未ログインユーザー向けコンテンツ --}}
    @guest
        <div class="py-12">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-body text-center py-5">
                                <h1 class="h3 mb-3">販売管理システムへようこそ</h1>
                                <p class="text-muted mb-4">
                                    このシステムを利用するには、ログインが必要です。<br>
                                    社内アカウントをお持ちの場合は、以下のボタンからログインしてください。
                                </p>

                                <div class="d-flex justify-content-center gap-3">
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                        ログイン
                                    </a>
                                </div>

                                <p class="mt-4 text-muted small">
                                    アカウントをお持ちでない場合は、管理者にお問い合わせください。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endguest
</x-app-layout>
