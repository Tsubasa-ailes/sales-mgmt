{{-- resources/views/sales_orders/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('受注詳細') }}
            </h2>

            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('sales_orders.index') }}" class="px-4 py-2 text-sm rounded-md border bg-white hover:bg-gray-50">
                    ← 受注一覧へ戻る
                </a>

                @if (is_null($order->invoice))
                    <a href="{{ route('invoices.create', $order->id) }}" class="btn btn-primary">
                        請求書を発行
                    </a>
                @else
                    <a href="{{ route('invoices.show', $order->invoice->id) }}" class="btn btn-primary">
                        請求書を見る
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- 基本情報 --}}
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">受注情報</h3>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600">受注ID</p>
                            <p class="font-semibold">{{ $order->id }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">受注日</p>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($order->ordered_at)->format('Y-m-d') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">ステータス</p>
                            @if ($order->status === 'confirmed')
                                <p class="font-semibold text-green-600">確定</p>
                            @elseif ($order->status === 'draft')
                                <p class="font-semibold text-gray-600">下書き</p>
                            @else
                                <p class="font-semibold text-red-600">キャンセル</p>
                            @endif
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">小計</p>
                            <p class="font-semibold">¥{{ intval($order->subtotal) }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">消費税</p>
                            <p class="font-semibold">¥{{ number_format($order->tax_total, 0) }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">合計</p>
                            <p class="font-bold text-lg">¥{{ intval($order->total) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 取引先情報 --}}
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">取引先情報</h3>

                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">取引先名</p>
                            <p class="font-semibold">{{ $order->partner->name ?? '—' }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">住所</p>
                            <p>{{ $order->partner->address ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 商品明細 --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">受注明細</h3>

                    @if ($order->items->isEmpty())
                        <p class="text-gray-500 text-center py-4">明細がありません。</p>
                    @else
                        <table class="table-auto w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-left border-b">
                                    <th class="px-4 py-2 w-36">商品コード</th>
                                    <th class="px-4 py-2">商品名</th>
                                    <th class="px-4 py-2 text-right w-20">数量</th>
                                    <th class="px-4 py-2 text-right w-32">単価</th>
                                    <th class="px-4 py-2 text-right w-32">金額</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-2">
                                            {{ $item->product->sku ?? '—' }}
                                        </td>
                                        <td class="px-4 py-2">
                                            {{ $item->product->name ?? '不明' }}
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            {{ intval($item->qty) }}
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            ¥{{ intval($item->unit_price) }}
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            ¥{{ intval($item->qty * $item->unit_price) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            {{-- 請求書情報（存在する場合） --}}
            @if ($order->invoice)
                <div class="bg-white shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">請求書情報</h3>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600">請求書番号</p>
                                <p class="font-semibold">{{ $order->invoice->invoice_no }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">発行日</p>
                                <p>
                                    {{ \Carbon\Carbon::parse($order->invoice->issued_at)->format('Y-m-d') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">支払期限</p>
                                <p>
                                    @if ($order->invoice->due_on)
                                        {{ \Carbon\Carbon::parse($order->invoice->due_on)->format('Y-m-d') }}
                                    @else
                                        —
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
