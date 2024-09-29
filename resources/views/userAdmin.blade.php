<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">ユーザー管理ページ</h1>

        <table class="min-w-full bg-white">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-center">社員番号</th>
                    <th class="py-3 px-6 text-center">名前</th>
                    <th class="py-3 px-6 text-center">役職</th>
                    <th class="py-3 px-6 text-center">部署</th>
                    <th class="py-3 px-6 text-center">登録日</th>
                    <th class="py-3 px-6 text-center">変更</th>
                    <!-- 必要に応じて他のカラムを追加 -->
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($users as $user)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-center">{{ $user->employee_id }}</td>
                    <td class="py-3 px-6 text-center">{{ $user->name }}</td>
                    <td class="py-3 px-6 text-center">{{ $user->position }}</td>
                    <td class="py-3 px-6 text-center">{{ $user->department }}</td>
                    <td class="py-3 px-6 text-center">{{ $user->created_at->format('Y-m-d') }}</td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('userEdit', $user->id) }}" class="text-blue-500 hover:underline">🔍</a>
                    </td>

                    <!-- 必要に応じて他のデータを表示 -->
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-1">
            {{ $users->links() }}
        </div>

    </div>
</x-app-layout>
