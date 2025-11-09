<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                商品新規登録
            </h2>

            <!-- {{-- 戻るボタン（一覧へ） --}} -->
            <!-- <a href="{{ route('products.index') }}" -->
               <!-- class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold rounded-md"> -->
                <!-- ← 一覧に戻る -->
            <!-- </a> -->
        <!-- </div> -->
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                {{-- バリデーションエラー表示 --}}
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('products.store') }}" onsubmit="return confirm('商品を登録しますか？');">
                    @csrf

                    <!-- <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">SKU（商品コード）</label>
                        <input type="text" name="sku" value="{{ old('sku') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div> -->

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">商品名</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">単価</label>
                        <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price', 0) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">消費税率（%）</label>
                        <input type="number" step="0.01" name="tax_rate" value="{{ old('tax_rate', 10) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">ステータス</label>
                        <select name="is_active"
                                class="mt-1 block w-40 border-gray-300 rounded-md shadow-sm">
                            <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>有効</option>
                            <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>無効</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold rounded-md">
                            登録する
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
