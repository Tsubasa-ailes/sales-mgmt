<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                新規ユーザー登録
            </h2>

            <!-- <a href="{{ route('users.index') }}"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold rounded-md">
                ユーザー一覧に戻る
            </a>  -->
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                {{-- バリデーションエラー --}}
                @if ($errors->any())
                    <div class="mb-4 text-red-600 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">名前</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">メールアドレス</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">パスワード</label>
                        <input type="password" name="password"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">パスワード（確認）</label>
                        <input type="password" name="password_confirmation"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">権限</label>
                        <select name="role"
                                class="mt-1 block w-40 border-gray-300 rounded-md shadow-sm">
                            <option value="0" {{ old('role', 0) == 0 ? 'selected' : '' }}>一般ユーザー</option>
                            <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>管理者</option>
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
