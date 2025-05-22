<nav x-data="{ open: false }" class="bg-maroon-800 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="#" class="flex items-center">
                        <img src="{{ asset('assets/img/logo.png') }}" class="h-10 w-auto mr-2" alt="">
                        <span class="text-white font-bold text-lg hidden md:block">Class Scheduler</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                @php
                $user = Auth::user();
                @endphp

                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                    @if ($user->role === 'admin')
                    <x-nav-link :href="route('admin.home')" :active="request()->routeIs('admin.home')" class="text-white hover:bg-maroon-700 px-4 py-2 rounded-lg transition-all">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/admin/subjects') }}" :active="request()->is('users/admin/subjects')" class="text-white hover:bg-maroon-700 px-4 py-2 rounded-lg transition-all">
                        <i class="fas fa-book me-2"></i> Subjects
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/admin/sections') }}" :active="request()->is('users/admin/sections')" class="text-white hover:bg-maroon-700 px-4 py-2 rounded-lg transition-all">
                        <i class="fas fa-layer-group me-2"></i> Sections
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/admin/rooms') }}" :active="request()->is('users/admin/rooms')" class="text-white hover:bg-maroon-700 px-4 py-2 rounded-lg transition-all">
                        <i class="fas fa-door-open me-2"></i> Rooms
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/admin/schedules') }}" :active="request()->is('users/admin/schedules')" class="text-white hover:bg-maroon-700 px-4 py-2 rounded-lg transition-all">
                        <i class="fas fa-calendar-alt me-2"></i> Schedules
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/admin/students') }}" :active="request()->is('users/admin/students')" class="text-white hover:bg-maroon-700 px-4 py-2 rounded-lg transition-all">
                        <i class="fas fa-user-graduate me-2"></i> Students
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/admin/teachers') }}" :active="request()->is('users/admin/teachers')" class="text-white hover:bg-maroon-700 px-4 py-2 rounded-lg transition-all">
                        <i class="fas fa-chalkboard-teacher me-2"></i> Teachers
                    </x-nav-link>

                    @elseif ($user->role === 'student')
                    <x-nav-link :href="route('students.home')" :active="request()->routeIs('students.home')" class="text-white hover:bg-maroon-700 px-4 py-2 rounded-lg transition-all">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/students/schedules') }}" :active="request()->is('users/students/schedules')" class="text-white hover:bg-maroon-700 px-4 py-2 rounded-lg transition-all">
                        <i class="fas fa-calendar-alt me-2"></i> My Schedules
                    </x-nav-link>

                    @elseif ($user->role === 'teacher')
                    <x-nav-link :href="route('teachers.home')" :active="request()->routeIs('teachers.home')" class="text-white hover:bg-maroon-700 px-4 py-2 rounded-lg transition-all">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </x-nav-link>
                    <x-nav-link href="{{ url('/users/teachers/schedules') }}" :active="request()->is('users/teachers/schedules')" class="text-white hover:bg-maroon-700 px-4 py-2 rounded-lg transition-all">
                        <i class="fas fa-calendar-check me-2"></i> Schedules
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-2 focus:outline-none">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('user-default.png') }}"
                                class="rounded-full object-cover border-2 border-mustard-500 shadow-sm"
                                alt="User Profile" style="height: 40px; width: 40px;">
                            <span class="text-white font-medium hidden md:inline">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-white text-xs"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content" class="bg-white rounded-lg shadow-xl border border-maroon-200 mt-2 py-1 w-48">
                        <!-- User Information -->
                        <div class="px-4 py-3 border-b border-maroon-100">
                            <p class="text-sm font-semibold text-maroon-800">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-xs text-maroon-600">
                                {{ ucfirst(Auth::user()->role) }}
                            </p>
                        </div>

                        <!-- Profile Link -->
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center px-4 py-2 text-sm text-maroon-800 hover:bg-maroon-50">
                            <i class="fas fa-user-circle text-maroon-600 mr-2"></i>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center px-4 py-2 text-sm text-maroon-800 hover:bg-maroon-50">
                                <i class="fas fa-sign-out-alt text-maroon-600 mr-2"></i>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-mustard-300 hover:bg-maroon-700 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-maroon-700">
        <div class="pt-2 pb-3 space-y-1">
            @if ($user->role === 'admin')
            <x-responsive-nav-link :href="route('admin.home')" :active="request()->routeIs('admin.*')" class="text-white hover:bg-maroon-600 px-4 py-2">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/admin/subjects') }}" :active="request()->is('users/admin/subjects')" class="text-white hover:bg-maroon-600 px-4 py-2">
                <i class="fas fa-book mr-2"></i> Subjects
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/admin/sections') }}" :active="request()->is('users/admin/sections')" class="text-white hover:bg-maroon-600 px-4 py-2">
                <i class="fas fa-layer-group mr-2"></i> Sections
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/admin/rooms') }}" :active="request()->is('users/admin/rooms')" class="text-white hover:bg-maroon-600 px-4 py-2">
                <i class="fas fa-door-open mr-2"></i> Rooms
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/admin/schedules') }}" :active="request()->is('users/admin/schedules')" class="text-white hover:bg-maroon-600 px-4 py-2">
                <i class="fas fa-calendar-alt mr-2"></i> Schedules
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/admin/students') }}" :active="request()->is('users/admin/students')" class="text-white hover:bg-maroon-600 px-4 py-2">
                <i class="fas fa-user-graduate mr-2"></i> Students
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/admin/teachers') }}" :active="request()->is('users/admin/teachers')" class="text-white hover:bg-maroon-600 px-4 py-2">
                <i class="fas fa-chalkboard-teacher mr-2"></i> Teachers
            </x-responsive-nav-link>

            @elseif ($user->role === 'student')
            <x-responsive-nav-link :href="route('students.home')" :active="request()->routeIs('students.*')" class="text-white hover:bg-maroon-600 px-4 py-2">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/students/schedules') }}" :active="request()->is('users/students/schedules')" class="text-white hover:bg-maroon-600 px-4 py-2">
                <i class="fas fa-calendar-alt mr-2"></i> My Schedules
            </x-responsive-nav-link>

            @elseif ($user->role === 'teacher')
            <x-responsive-nav-link :href="route('teachers.home')" :active="request()->routeIs('teachers.*')" class="text-white hover:bg-maroon-600 px-4 py-2">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ url('/users/teachers/schedules') }}" :active="request()->is('users/teachers/schedules')" class="text-white hover:bg-maroon-600 px-4 py-2">
                <i class="fas fa-calendar-check mr-2"></i> Schedules
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-maroon-600">
            <div class="px-4 py-3">
                <div class="font-medium text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-mustard-300">{{ ucfirst(Auth::user()->role) }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:bg-maroon-600 px-4 py-2">
                    <i class="fas fa-user-circle mr-2"></i> Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-white hover:bg-maroon-600 px-4 py-2">
                        <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>