<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-3xl font-extrabold text-gray-900">Reset Password</h2>
    </div>

    <div class="mb-6 text-sm text-gray-600 leading-relaxed text-center">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 text-base">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out">
                &larr; Back to login
            </a>
        </div>
    </form>
</x-guest-layout>