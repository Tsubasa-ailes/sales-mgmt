<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('取引先登録') }}
            </h2>

            {{-- <a href="{{ url('/') }}"
               class="px-4 py-2 text-sm rounded-md border bg-white hover:bg-gray-50">
                ← 戻る
            </a>--}}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-50 text-green-800 rounded border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('partners.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium mb-1">取引先名 *</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">区分 *</label>
                            <select name="type"
                                class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500">
                                <option value="">選択してください</option>
                                <option value="customer" {{ old('type') === 'customer' ? 'selected' : '' }}>得意先</option>
                                <option value="supplier" {{ old('type') === 'supplier' ? 'selected' : '' }}>仕入先</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">請求先郵便番号</label>
                                <input type="text" name="billing_postal" value="{{ old('billing_postal') }}"
                                    placeholder="例：123-4567"
                                    class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">メール</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">請求先住所</label>
                            <input type="text" name="billing_address" value="{{ old('billing_address') }}"
                                class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="flex justify-end gap-3 pt-2">
                            <a href="{{ url('/') }}"
                                class="btn btn-danger">
                                キャンセル
                            </a>
                            <button type="submit"
                                class="btn btn-primary">
                                登録
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
