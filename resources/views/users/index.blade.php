<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ユーザー一覧
            </h2>

            <!-- <a href="{{ route('users.create') }}"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-md">
                新規ユーザー登録
            </a> -->
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if (session('status'))
                    <div class="mb-4 text-green-600 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($users->isEmpty())
                    <p>ユーザーが登録されていません。</p>
                @else
                    <table class="table-auto w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-100">
                                <th class="p-2">ID</th>
                                <th class="p-2">名前</th>
                                <th class="p-2">メールアドレス</th>
                                <th class="p-2">作成日</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-2">{{ $user->id }}</td>
                                    <td class="p-2">{{ $user->name }}</td>
                                    <td class="p-2">{{ $user->email }}</td>
                                    <td class="p-2">{{ $user->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
