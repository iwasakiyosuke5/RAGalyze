<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">ユーザー編集ページ</h1>

        <!-- 名前と社員番号は変更不可、表示のみ -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name" readonly />
        </div>

        <div class="mt-4">
            <x-input-label for="employee_id" :value="__('Employee No.')" />
            <x-text-input id="employee_id" class="border border-gray-300 block pl-3 mt-1 w-full" type="text" name="employee_id" :value="$user->employee_id" readonly />
        </div>

        <!-- 編集可能なポジションと部署 -->
        <form method="POST" action="{{ route('userUpdate', $user->id) }}">
            @csrf
            @method('PUT') <!-- LaravelでPUTメソッドを使用してデータを更新するための指示 -->

            <!-- Position -->
            <div class="mt-4">
                <x-input-label for="position" :value="__('Position')" />
                <select id="position" name="position" class="rounded-lg block mt-1 w-full">
                    <option value="GM" {{ $user->position == 'GM' ? 'selected' : '' }}>GM</option>
                    <option value="GL" {{ $user->position == 'GL' ? 'selected' : '' }}>GL</option>
                    <option value="TL" {{ $user->position == 'TL' ? 'selected' : '' }}>TL</option>
                    <option value="SiSP/SP." {{ $user->position == 'SiSP/SP.' ? 'selected' : '' }}>Senior/Specialist</option>
                </select>
            </div>

            <!-- Department -->
            <div class="mt-4">
                <x-input-label for="department" :value="__('Department')" />
                <select id="department" name="department" class="rounded-lg block mt-1 w-full">
                    <option value="PC_Res" {{ $user->department == 'PC_Res' ? 'selected' : '' }}>PC Research</option>
                    <option value="LS_Dept" {{ $user->department == 'LS_Dept' ? 'selected' : '' }}>LS Dept.</option>
                    <option value="MS_Dept" {{ $user->department == 'MS_Dept' ? 'selected' : '' }}>MS Dept.</option>
                    <option value="GS_Dept" {{ $user->department == 'GS_Dept' ? 'selected' : '' }}>GS Dept.</option>
                    <option value="BS_Dept" {{ $user->department == 'BS_Dept' ? 'selected' : '' }}>BS Dept.</option>
                    <option value="Ch_Dept" {{ $user->department == 'Ch_Dept' ? 'selected' : '' }}>Shanghai Dept.</option>
                </select>
            </div>

            <div class="flex justify-end mt-6">
                <button class="rounded-md bg-sky-500 py-2 px-3 text-gray-50 hover:bg-sky-700 active:scale-95 active:shadow-lg transition-transform duration-100" type="submit">
                    Update!
                </button>
            </div>
            <div class="flex justify-end mt-6">
                <a href="{{ route('userAdmin') }}" class="rounded-md bg-rose-500 py-2 px-3 text-gray-50 hover:bg-rose-700">ユーザー一覧へ</a>
            </div>
        </form>

    </div>
</x-app-layout>
