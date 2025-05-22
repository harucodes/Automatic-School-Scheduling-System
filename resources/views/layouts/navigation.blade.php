<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="#">
                        <img src="{{ asset('assets/img/logo.png') }}" class="h-10 w-12" alt="">
                    </a>
                </div>

                <!-- Navigation Links -->
                @php
                $user = Auth::user();
                @endphp

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if ($user->role === 'admin')
                    <x-nav-link :href="route('admin.home')" :active="request()->routeIs('admin.home')">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/admin/subjects') }}" :active="request()->is('users/admin/subjects')">
                        <i class="fas fa-book me-1"></i> Subjects
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/admin/sections') }}" :active="request()->is('users/admin/sections')">
                        <i class="fas fa-layer-group me-1"></i> Sections
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/admin/rooms') }}" :active="request()->is('users/admin/rooms')">
                        <i class="fas fa-door-open me-1"></i> Rooms
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/admin/schedules') }}" :active="request()->is('users/admin/schedules')">
                        <i class="fas fa-calendar-alt me-1"></i> Schedules
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/admin/students') }}" :active="request()->is('users/admin/students')">
                        <i class="fas fa-user-graduate me-1"></i> Students
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/admin/teachers') }}" :active="request()->is('users/admin/teachers')">
                        <i class="fas fa-chalkboard-teacher me-1"></i> Teachers
                    </x-nav-link>

                    @elseif ($user->role === 'student')
                    <x-nav-link :href="route('students.home')" :active="request()->routeIs('students.home')">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/students/schedules') }}" :active="request()->is('users/students/schedules')">
                        <i class="fas fa-calendar-alt me-1"></i> My Schedules
                    </x-nav-link>

                    @elseif ($user->role === 'teacher')
                    <x-nav-link :href="route('teachers.home')" :active="request()->routeIs('teachers.home')">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/teachers/schedules') }}" :active="request()->is('users/teachers/schedules')">
                        <i class="fas fa-calendar-check me-1"></i> Schedules
                    </x-nav-link>
                    @endif
                </div>




            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <button id="theme-toggle" type="button"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-3 px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-200 focus:outline-none transition duration-150">
                            <!-- Profile Image -->
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('user-default.png') }}"
                                class="rounded-full object-cover border border-gray-300 shadow-sm"
                                alt="User Profile" style="height: 40px; width: 40px;">
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- User Information in Dropdown -->
                        <div class="px-4 py-3 text-center">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('user-default.png') }}"
                                class="mx-auto rounded-full object-cover border border-gray-300 shadow-sm"
                                alt="User Profile" style="height: 40px; width: 40px;">
                            <p class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ Auth::user()->role }}
                            </p>
                        </div>

                        <hr class="border-gray-200 dark:border-gray-600">

                        <!-- Profile Link -->
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center px-4 py-2">
                            <i class="fas fa-user-circle text-gray-600 dark:text-gray-300 mr-2"></i>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Profile') }}</span>
                        </x-dropdown-link>
                        <hr class="border-gray-200 dark:border-gray-600">
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center px-4 py-2">
                                <i class="fas fa-sign-out-alt text-gray-600 dark:text-gray-300 mr-2"></i>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Log Out') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @php
            $user = Auth::user();
            @endphp

            @if ($user->role === 'admin')
            <x-responsive-nav-link :href="route('admin.home')" :active="request()->routeIs('admin.*')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/admin/subjects') }}" :active="request()->is('users/admin/subjects')">
                {{ __('Subjects') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/admin/sections') }}" :active="request()->is('users/admin/sections')">
                {{ __('Sections') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/admin/rooms') }}" :active="request()->is('users/admin/rooms')">
                {{ __('Rooms') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/admin/schedules') }}" :active="request()->is('users/admin/schedules')">
                {{ __('schedules for teachers') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/admin/students') }}" :active="request()->is('users/admin/students')">
                {{ __('Students') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/admin/teachers') }}" :active="request()->is('users/admin/teachers')">
                {{ __('Teachers') }}
            </x-responsive-nav-link>

            @elseif ($user->role === 'student')
            <x-responsive-nav-link :href="route('students.home')" :active="request()->routeIs('students.*')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/students/schedules') }}" :active="request()->is('users/students/schedules')">
                {{ __('My schedules') }}
            </x-responsive-nav-link>

            @elseif ($user->role === 'teacher')
            <x-responsive-nav-link :href="route('teachers.home')" :active="request()->routeIs('teachers.*')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/teachers/schedules') }}" :active="request()->is('users/teachers/schedules')">
                {{ __('schedules') }}
            </x-responsive-nav-link>
            @endif

        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>