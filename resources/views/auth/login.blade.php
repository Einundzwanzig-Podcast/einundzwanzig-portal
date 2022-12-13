<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo/>
        </x-slot>

        <x-jet-validation-errors class="mb-4"/>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">

            <div class="flex items-center justify-end mb-4">
                <x-button icon="arrow-left" secondary class="ml-4" href="/">
                    {{ __('Zurück zur Webseite') }}
                </x-button>
            </div>

            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}"/>
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                             required autofocus/>
                <pre>admin@einundzwanzig.space</pre>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}"/>
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                             autocomplete="current-password"/>
                <pre>1234</pre>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember"/>
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            @if(app()->environment('local'))
                <div class="flex items-center justify-end mt-4">

                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900"
                           href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-jet-button class="ml-4">
                        {{ __('Log in') }}
                    </x-jet-button>

                </div>
            @endif

            <div class="flex items-center justify-left mt-4">
                <x-button href="{{ route('auth.ln') }}" primary icon="lightning-bolt">LNURL-Auth</x-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
