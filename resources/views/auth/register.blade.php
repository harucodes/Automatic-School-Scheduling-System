<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-maroon-700">
                {{ __('Name') }}
            </label>
            <input id="name"
                class="mt-1 block w-full rounded-md border-maroon-200 shadow-sm focus:border-mustard-500 focus:ring-mustard-500"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name">
            @error('name')
            <p class="mt-2 text-sm text-maroon-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- ID Number -->
        <div>
            <label for="id_number" class="block text-sm font-medium text-maroon-700">
                {{ __('ID Number') }}
            </label>
            <input id="id_number"
                class="mt-1 block w-full rounded-md border-maroon-200 shadow-sm focus:border-mustard-500 focus:ring-mustard-500"
                type="text"
                name="id_number"
                value="{{ old('id_number') }}"
                required
                autocomplete="id_number">
            @error('id_number')
            <p class="mt-2 text-sm text-maroon-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-maroon-700">
                {{ __('Email') }}
            </label>
            <input id="email"
                class="mt-1 block w-full rounded-md border-maroon-200 shadow-sm focus:border-mustard-500 focus:ring-mustard-500"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username">
            @error('email')
            <p class="mt-2 text-sm text-maroon-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Role Select -->
        <div>
            <label for="role" class="block text-sm font-medium text-maroon-700">
                {{ __('Register as') }}
            </label>
            <select id="role"
                name="role"
                required
                class="mt-1 block w-full rounded-md border-maroon-200 shadow-sm focus:border-mustard-500 focus:ring-mustard-500">
                <option value="" disabled selected>-- Select Role --</option>
                <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
            </select>
            @error('role')
            <p class="mt-2 text-sm text-maroon-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-maroon-700">
                {{ __('Password') }}
            </label>
            <input id="password"
                class="mt-1 block w-full rounded-md border-maroon-200 shadow-sm focus:border-mustard-500 focus:ring-mustard-500"
                type="password"
                name="password"
                required
                autocomplete="new-password">
            @error('password')
            <p class="mt-2 text-sm text-maroon-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-maroon-700">
                {{ __('Confirm Password') }}
            </label>
            <input id="password_confirmation"
                class="mt-1 block w-full rounded-md border-maroon-200 shadow-sm focus:border-mustard-500 focus:ring-mustard-500"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password">
            @error('password_confirmation')
            <p class="mt-2 text-sm text-maroon-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-maroon-600 hover:text-mustard-700 underline"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-maroon-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-maroon-700 focus:bg-maroon-700 active:bg-maroon-800 focus:outline-none focus:ring-2 focus:ring-mustard-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</x-guest-layout>