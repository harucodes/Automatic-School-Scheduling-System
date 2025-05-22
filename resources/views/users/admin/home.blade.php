<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Students Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-maroon-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-maroon-100 text-maroon-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-maroon-600">Total Students</p>
                                <p class="text-2xl font-semibold text-maroon-800">{{ $studentCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Teachers Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-maroon-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-mustard-100 text-mustard-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-maroon-600">Total Teachers</p>
                                <p class="text-2xl font-semibold text-maroon-800">{{ $teacherCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rooms Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-maroon-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-maroon-100 text-maroon-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-maroon-600">Available Rooms</p>
                                <p class="text-2xl font-semibold text-maroon-800">{{ $roomCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Schedules Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-maroon-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-mustard-100 text-mustard-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-maroon-600">Active Schedules</p>
                                <p class="text-2xl font-semibold text-maroon-800">{{ $scheduleCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Students Per Section Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-maroon-200">
                    <h3 class="text-lg font-medium text-maroon-800 mb-4">Students per Section</h3>
                    <canvas id="studentsPerSectionChart" height="250"></canvas>
                </div>

                <!-- Room Utilization Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-maroon-200">
                    <h3 class="text-lg font-medium text-maroon-800 mb-4">Rooms Chart</h3>
                    <canvas id="roomChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const sectionLabels = @json($studentsPerSection->pluck('section_name'));
const studentCounts = @json($studentsPerSection->pluck('student_count'));

new Chart(document.getElementById('studentsPerSectionChart'), {
    type: 'bar',
    data: {
        labels: sectionLabels,
        datasets: [{
            label: 'Students per Section',
            data: studentCounts,
            backgroundColor: 'rgba(155, 26, 26, 0.7)',
            borderColor: 'rgba(155, 26, 26, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});

const ctx = document.getElementById('roomChart').getContext('2d');
const roomLabels = @json($roomLabels);
const roomCounts = @json($roomCounts);

const roomChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: roomLabels,
        datasets: [{
            label: 'Number of Students',
            data: roomCounts,
            backgroundColor: 'rgba(255, 196, 56, 0.7)',
            borderColor: 'rgba(255, 196, 56, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                precision: 0,
                title: {
                    display: true,
                    text: 'Students'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Room Number'
                }
            }
        }
    }
});
</script>
</x-app-layout>