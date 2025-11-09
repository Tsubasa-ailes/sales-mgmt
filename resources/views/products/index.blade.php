<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品一覧
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">登録商品一覧</h3>

                @if($products->isEmpty())
                    <p>商品が登録されていません。</p>
                @else
                    @if (session('status'))
                        <div class="mb-4 text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table-auto w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-100">
                                <th class="p-2">ID</th>
                                <th class="p-2">品番</th>
                                <th class="p-2">商品名</th>
                                <th class="p-2">単価</th>
                                <th class="p-2">消費税率</th>
                                <th class="p-2">ステータス</th>
                            </tr>
                        </thead>
                        <tbody?>
                            @foreach ($products as $product)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-2">{{ $product->id }}</td>
                                    <td class="p-2">{{ $product->sku }}</td>
                                    <td class="p-2">{{ $product->name }}</td>
                                    <td class="p-2">{{ number_format($product->unit_price).'円' }}</td>
                                    <td class="p-2">{{ $product->tax_rate }}%</td>
                                    <td class="p-2">{{ $product->is_active ? '有効' : '無効' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>    