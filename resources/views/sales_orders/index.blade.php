{{-- resources/views/sales_orders/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('受注一覧') }}
            </h2>
            <a href="{{ route('sales_orders.create') }}" 
                class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition">
                ＋ 新規受注登録
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- 成功メッセージ --}}
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($orders->isEmpty())
                        <p class="text-center text-gray-500">受注データがありません。</p>
                    @else
                        <table class="table-auto w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-left border-b">
                                    <th class="px-4 py-2 w-24">受注日</th>
                                    <th class="px-4 py-2">取引先</th>
                                    <th class="px-4 py-2 text-right">小計</th>
                                    <th class="px-4 py-2 text-right">消費税</th>
                                    <th class="px-4 py-2 text-right">合計</th>
                                    <th class="px-4 py-2">ステータス</th>
                                    <th class="px-4 py-2 w-32 text-center">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($order->ordered_at)->format('Y-m-d') }}</td>
                                        <td class="px-4 py-2">{{ $order->partner->name ?? '—' }}</td>
                                        <td class="px-4 py-2 text-right">{{ number_format($order->subtotal, 0) }}</td>
                                        <td class="px-4 py-2 text-right">{{ number_format($order->tax_total, 0) }}</td>
                                        <td class="px-4 py-2 text-right font-semibold">{{ number_format($order->total, 0) }}</td>
                                        <td class="px-4 py-2">
                                            @if ($order->status === 'confirmed')
                                                <span class="text-green-600 font-medium">確定</span>
                                            @elseif ($order->status === 'draft')
                                                <span class="text-gray-600">下書き</span>
                                            @else
                                                <span class="text-red-600">キャンセル</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            {{--<a href="{{ route('sales_orders.show', $order->id) }}" 
                                                class="text-blue-600 hover:underline">詳細</a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
