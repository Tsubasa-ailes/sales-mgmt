{{-- resources/views/sales_orders/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                受注登録
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="container mt-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    {{-- バリデーションエラー表示 --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('sales_orders.store') }}">
                        @csrf

                        {{-- 取引先 --}}
                        <div class="mb-3">
                            <label class="form-label">取引先</label>
                            <select name="partner_id" class="form-select">
                                <option value="">選択してください</option>
                                @foreach ($partners as $partner)
                                    <option value="{{ $partner->id }}" {{ old('partner_id') == $partner->id ? 'selected' : '' }}>
                                        {{ $partner->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 倉庫 --}}
                        <div class="mb-3">
                            <label class="form-label">倉庫</label>
                            <select name="warehouse_id" class="form-select">
                                <option value="">選択してください</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 受注日 --}}
                        <div class="mb-3">
                            <label class="form-label">受注日</label>
                            <input type="date"
                                name="ordered_at"
                                value="{{ old('ordered_at', now()->toDateString()) }}"
                                class="form-control">
                        </div>

                        <hr>

                        {{-- 明細1行目 --}}
                        <h5 class="mb-2">明細</h5>
                        <div class="row mb-2">
                            <div class="col-md-5">
                                <label class="form-label">商品</label>
                                <select name="items[0][product_id]" class="form-select">
                                    <option value="">選択してください</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ old('items.0.product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">数量</label>
                                <input type="number"
                                    name="items[0][qty]"
                                    step="0.001"
                                    min="0"
                                    value="{{ old('items.0.qty') }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">単価</label>
                                <input type="number"
                                    name="items[0][unit_price]"
                                    step="0.01"
                                    min="0"
                                    value="{{ old('items.0.unit_price') }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">税率(%)</label>
                                <input type="number"
                                    name="items[0][tax_rate]"
                                    step="0.01"
                                    min="0"
                                    max="20"
                                    value="{{ old('items.0.tax_rate', 10.00) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary">登録する</button>
                        </div>
                    </form>
                </div> {{-- card-body --}}
            </div> {{-- card --}}
        </div> {{-- container --}}
    </div> {{-- py-6 --}}
</x-app-layout>
