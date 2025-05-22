<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    maroon: {
                        100: "#f3dede",
                        200: "#e0bdbd",
                        600: "#9b1a1a",
                        800: "#660000",
                    },
                    mustard: {
                        100: "#fff4cc",
                        600: "#ffc438",
                    }
                }
            }
        }
    }
</script>

<body>

    <div class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80')">
        <div class="max-w-md w-full mx-4 bg-white bg-opacity-90 backdrop-blur-sm rounded-xl shadow-xl overflow-hidden border border-maroon-200">
            <div class="p-8">
                <!-- Logo/School Name -->
                <div class="flex justify-center mb-8">
                    <div class="text-center">
                        <a href="#"> <img src="{{ asset('assets/img/logo.png' ) }}" alt="logo" class='w-40 mb-8 mx-auto block' />
                        </a>
                        <h1 class="text-3xl font-bold text-maroon-800">University</h1>
                        <p class="text-maroon-600">Automated Scheduling System</p>
                    </div>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                <div class="mb-6 p-4 bg-mustard-100 text-maroon-800 rounded-lg border border-mustard-200">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-maroon-700 mb-2">
                            {{ __('Email Address') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-maroon-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                            </div>
                            <input id="email"
                                class="block w-full pl-10 pr-3 py-3 rounded-lg border-maroon-200 shadow-sm focus:border-mustard-500 focus:ring-mustard-500 placeholder-maroon-300"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="your@email.com"
                                required
                                autofocus
                                autocomplete="username">
                        </div>
                        @error('email')
                        <p class="mt-2 text-sm text-maroon-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-maroon-700 mb-2">
                            {{ __('Password') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-maroon-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input id="password"
                                class="block w-full pl-10 pr-3 py-3 rounded-lg border-maroon-200 shadow-sm focus:border-mustard-500 focus:ring-mustard-500 placeholder-maroon-300"
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                required
                                autocomplete="current-password">
                        </div>
                        @error('password')
                        <p class="mt-2 text-sm text-maroon-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input id="remember_me"
                                type="checkbox"
                                class="h-4 w-4 rounded border-maroon-300 text-mustard-600 focus:ring-mustard-500"
                                name="remember">
                            <label for="remember_me" class="ml-2 block text-sm text-maroon-600">
                                {{ __('Remember me') }}
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                        <a class="text-sm text-maroon-600 hover:text-mustard-700 transition-colors duration-200"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                        @endif
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-gradient-to-r from-maroon-600 to-maroon-700 hover:from-maroon-700 hover:to-maroon-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mustard-500 transition-all duration-200">
                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>

                @if (Route::has('register'))
                <div class="mt-6 text-center">
                    <p class="text-sm text-maroon-600">
                        {{ __("Don't have an account?") }}
                        <a href="{{ route('register') }}" class="font-medium text-mustard-600 hover:text-mustard-700 transition-colors duration-200">
                            {{ __('Register') }}
                        </a>
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>

</body>

</html>