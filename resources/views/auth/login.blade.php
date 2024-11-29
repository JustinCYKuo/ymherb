<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <p class="font-mono text-4xl font-semibold">{{ __('陽明山藥草園') }}</p>
            <p class="font-mono text-4xl font-medium">{{ __('後台管理系統') }}</p>
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div> --}}
            <div>
                <x-label for="employee_id" value="{{ __('員工編號') }}" />
                <x-input id="employee_id" class="block mt-1 w-full" type="text" name="employee_id" :value="old('employee_id')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('密碼') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('記住我') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('忘記密碼?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('登入') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
