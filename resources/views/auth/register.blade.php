<x-guest-layout>

@if (Route::has('login'))
    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        @auth
            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
            @endif
        @endauth
    </div>
@endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- employee_id -->
        <div class="mt-4">
            <x-input-label for="employee_id" :value="__('Employee No.')" />
            <x-text-input id="employee_id" class="border border-gray-300 block pl-3 mt-1 w-full" type="" name="employee_id" :value="old('employee_id')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('employee_id')" class="mt-2" />
        </div>


        <!-- Position -->
        <div class="mt-4">
            <x-input-label for="position" :value="__('Position')" />
            <select id="position" name="position" class="rounded-lg block mt-1 w-full">
                <option value="GM">GM</option>
                <option value="GL">GL</option>
                <option value="TL">TL</option>
                <option value="SiSP/SP.">Senior/Specialist</option>
            </select>
            <x-input-error :messages="$errors->get('position')" class="mt-2" />
        </div>
        
        <!-- Depertment -->
        <div class="mt-4">
            <x-input-label for="department" :value="__('Depertment')" />
             <select id="department" name="department" class="rounded-lg block mt-1 w-full">
                <option value="PC_Res">PC Research</option>
                <option value="LS_Dept">LS Dept.</option>
                <option value="MS_Dept">MS Dept.</option>
                <option value="GS_Dept">GS Dept.</option>
                <option value="BS_Dept">BS Dept.</option>
                <option value="Ch_Dept">Shanghai Dept.</option>
            </select>
            <x-input-error :messages="$errors->get('department')" class="mt-2" />
        </div>


        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password (8 Chars Req.)')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
