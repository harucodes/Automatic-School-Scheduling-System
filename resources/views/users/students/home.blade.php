<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="text-center mb-12 animate-fade-in">
                <h1 class="text-4xl font-bold text-maroon-800 mb-4">Automated Class Scheduling System</h1>
                <p class="text-lg text-maroon-600 max-w-2xl mx-auto">
                    An intelligent platform that optimizes your academic schedule, ensuring seamless class management and conflict-free timetables.
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 border border-maroon-200">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 bg-maroon-100 p-3 rounded-lg">
                            <svg class="h-6 w-6 text-maroon-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-maroon-800 mb-1">Smart Scheduling</h3>
                            <p class="text-maroon-600">
                                Automatically generated timetables that prevent conflicts and optimize your learning experience.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 border border-maroon-200">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 bg-mustard-100 p-3 rounded-lg">
                            <svg class="h-6 w-6 text-mustard-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-maroon-800 mb-1">Real-time Updates</h3>
                            <p class="text-maroon-600">
                                Instant notifications for any schedule changes, room adjustments, or class cancellations.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 border border-maroon-200">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 bg-maroon-100 p-3 rounded-lg">
                            <svg class="h-6 w-6 text-maroon-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-maroon-800 mb-1">Teacher Access</h3>
                            <p class="text-maroon-600">
                                Easy access to instructor information and availability for better communication.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 border border-maroon-200">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 bg-mustard-100 p-3 rounded-lg">
                            <svg class="h-6 w-6 text-mustard-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-maroon-800 mb-1">Room Management</h3>
                            <p class="text-maroon-600">
                                Clear information about classroom locations and capacities for optimal space utilization.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center animate-fade-in-up">
                <div class="inline-block bg-white p-6 rounded-lg shadow-sm border border-maroon-200">
                    <h3 class="text-lg font-medium text-maroon-800 mb-2">Ready to view your schedule?</h3>
                    <a href="{{ url('/users/students/schedules') }}" class="inline-flex items-center px-4 py-2 bg-maroon-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-maroon-700 active:bg-maroon-800 focus:outline-none focus:border-maroon-900 focus:ring ring-maroon-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="fa-solid fa-calendar-days mr-2"></i>
                        View My Schedule
                        <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 1s ease-out;
        }

        .animate-fade-in-up {
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</x-app-layout>