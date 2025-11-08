<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            取引先一覧
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">登録取引先一覧</h3>

                @if ($partners->isEmpty())
                    <p>取引先が登録されていません。</p>
                @else
                    <table class="table-auto w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-100">
                                <th class="p-2">ID</th>
                                <th class="p-2">取引先名</th>
                                <th class="p-2">区分</th>
                                <th class="p-2">請求先郵便番号</th>
                                <th class="p-2">請求先住所</th>
                                <th class="p-2">メールアドレス</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($partners as $partner)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-2">{{ $partner->id }}</td>
                                    <td class="p-2">{{ $partner->name }}</td>
                                    <td class="p-2">
                                        @if ($partner->type === 'customer')
                                            顧客
                                        @elseif ($partner->type === 'supplier')
                                            仕入先
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="p-2">{{ $partner->billing_postal ?? '-' }}</td>
                                    <td class="p-2">{{ $partner->billing_address ?? '-' }}</td>
                                    <td class="p-2">{{ $partner->email ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
