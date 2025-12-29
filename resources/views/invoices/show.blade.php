{{-- resources/views/invoices/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('請求書') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    請求書番号：<span class="font-semibold">{{ $invoice->invoice_no }}</span>
                </p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                @if ($invoice->order)
                    <a href="{{ route('sales_orders.show', ['sales_order' => $invoice->order->id]) }}"
                       class="px-4 py-2 text-sm rounded-md border bg-white hover:bg-gray-50">
                        ← 受注詳細へ戻る
                    </a>
                @endif

                {{-- PDF機能を後で作るならここにボタンを置く --}}
                {{-- <a href="{{ route('invoices.pdf', $invoice->id) }}" class="px-4 py-2 text-sm rounded-md bg-gray-800 text-white">PDF</a> --}}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ステータスメッセージ --}}
            @if (session('status'))
                <div class="p-4 bg-green-50 text-green-800 rounded-md border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            {{-- 請求書ヘッダー情報 --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">請求書情報</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                        <div>
                            <p class="text-gray-600">請求書番号</p>
                            <p class="font-semibold text-base">{{ $invoice->invoice_no }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600">発行日</p>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($invoice->issued_at)->format('Y-m-d') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-600">支払期限</p>
                            <p class="font-semibold">
                                @if ($invoice->due_on)
                                    {{ \Carbon\Carbon::parse($invoice->due_on)->format('Y-m-d') }}
                                @else
                                    —
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-600">対象受注ID</p>
                            <p class="font-semibold">
                                {{ $invoice->sales_order_id ?? '—' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 取引先情報 --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">取引先情報</h3>

                    <div class="space-y-2 text-sm">
                        <div>
                            <p class="text-gray-600">取引先名</p>
                            <p class="font-semibold">
                                {{ $invoice->order->partner->name ?? '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-600">住所</p>
                            <p>
                                {{ $invoice->order->partner->billing_address ?? '—' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 明細 --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">明細</h3>

                    @php
                        $items = $invoice->order?->items ?? collect();
                    @endphp

                    @if ($items->isEmpty())
                        <p class="text-gray-500 text-center py-4">明細がありません。</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse text-sm">
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
                                    @foreach ($items as $item)
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
                                                ¥{{ number_format($item->unit_price, 0) }}
                                            </td>
                                            <td class="px-4 py-2 text-right">
                                                ¥{{ number_format($item->qty * $item->unit_price, 0) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- 合計 --}}
                        <div class="mt-6 flex justify-end">
                            <div class="w-full sm:w-80 space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">小計</span>
                                    <span class="font-semibold">¥{{ number_format($invoice->subtotal, 0) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">消費税</span>
                                    <span class="font-semibold">¥{{ number_format($invoice->tax_total, 0) }}</span>
                                </div>
                                <div class="flex justify-between border-t pt-2">
                                    <span class="text-gray-700 font-semibold">合計</span>
                                    <span class="text-lg font-bold">¥{{ number_format($invoice->total, 0) }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
