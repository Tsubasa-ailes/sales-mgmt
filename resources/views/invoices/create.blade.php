{{-- resources/views/invoices/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('請求書発行') }}
            </h2>
            {{-- <a href="{{ route('sales_orders.show', $order->id) }}"
                class="bg-gray-600 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-700 transition">
                ← 受注詳細へ戻る
            </a>--}}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- エラー --}}
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    <ul class="text-sm list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- 受注情報 --}}
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">受注情報</h3>
                    <div class="space-y-1 mb-6 text-sm">
                        <p>受注ID：<span class="font-semibold">{{ $order->id }}</span></p>
                        <p>受注日：<span class="font-semibold">{{ $order->ordered_at }}</span></p>
                        <p>取引先：<span class="font-semibold">{{ $order->partner->name ?? '—' }}</span></p>
                        <p>小計：<span class="font-semibold">¥{{ intval($order->subtotal) }}</span></p>
                        <p>税額：<span class="font-semibold">¥{{ number_format($order->tax_total, 0) }}</span></p>
                        <p>合計：<span class="font-bold text-lg">¥{{ intval($order->total) }}</span></p>
                    </div>

                    {{-- 請求書情報 --}}
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">請求書情報</h3>

                    <form method="POST" action="{{ route('invoices.store', $order->id) }}">
                        @csrf

                        {{-- 請求書番号 --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">請求書番号 *</label>
                            <input type="text" name="invoice_no" value="{{ old('invoice_no') }}"
                                class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md w-full text-sm">
                        </div>

                        {{-- 発行日 --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">請求日 *</label>
                            <input type="date" name="issued_at" value="{{ old('issued_at', now()->toDateString()) }}"
                                class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md text-sm">
                        </div>

                        {{-- 支払期限 --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-1">支払期限</label>
                            <input type="date" name="due_on" value="{{ old('due_on') }}"
                                class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md text-sm">
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('sales_orders.show', $order->id) }}"
                                class="px-4 py-2 text-sm rounded-md border">
                                キャンセル
                            </a>
                            <button type="submit"
                                class="px-4 py-2 text-sm rounded-md bg-blue-600 text-white hover:bg-blue-700">
                                請求書発行
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
