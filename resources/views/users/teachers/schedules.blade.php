<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Teacher Schedule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Your Teaching Schedule</h3>
                        <a href="{{ route('teacher.schedule.export') }}"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                            Export to Excel
                        </a>
                    </div>

                    <!-- Table View -->
                    <div class="mb-8">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg">
                                <thead>
                                    <tr class="bg-gray-100 dark:bg-gray-600">
                                        <th class="py-3 px-4 text-left">Day</th>
                                        <th class="py-3 px-4 text-left">Time</th>
                                        <th class="py-3 px-4 text-left">Subject</th>
                                        <th class="py-3 px-4 text-left">Section</th>
                                        <th class="py-3 px-4 text-left">Room</th>
                                        <th class="py-3 px-4 text-left">Students</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schedules as $schedule)
                                    <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="py-3 px-4">{{ ucfirst($schedule->day) }}</td>
                                        <td class="py-3 px-4">
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} -
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                        </td>
                                        <td class="py-3 px-4">{{ $schedule->subject->subject_name ?? 'N/A' }}</td>
                                        <td class="py-3 px-4">{{ $schedule->section->section_level ?? 'N/A' }}</td>
                                        <td class="py-3 px-4">{{ $schedule->room->room_number ?? 'N/A' }}</td>
                                        <td class="py-3 px-4">{{ $schedule->students->count() }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="py-4 px-4 text-center">No teaching schedules found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Spreadsheet-like View -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium mb-4">Weekly Schedule Overview</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg border-collapse">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-300 dark:border-gray-600 py-2 px-4">Time</th>
                                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                        <th class="border border-gray-300 dark:border-gray-600 py-2 px-4">{{ $day }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $timeSlots = [];
                                    $start = \Carbon\Carbon::parse('07:00');
                                    $end = \Carbon\Carbon::parse('19:00');

                                    while ($start <= $end) {
                                        $timeSlots[]=$start->format('h:i A');
                                        $start->addMinutes(30);
                                        }
                                        @endphp

                                        @foreach($timeSlots as $time)
                                        <tr>
                                            <td class="border border-gray-300 dark:border-gray-600 py-2 px-4 text-sm">{{ $time }}</td>
                                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                            @php
                                            $hasClass = false;
                                            $classInfo = null;

                                            foreach($schedules as $schedule) {
                                            if (strtolower($schedule->day) == strtolower($day)) {
                                            $startTime = \Carbon\Carbon::parse($schedule->start_time);
                                            $endTime = \Carbon\Carbon::parse($schedule->end_time);
                                            $currentTime = \Carbon\Carbon::parse($time);

                                            if ($currentTime->between($startTime, $endTime->subMinute())) {
                                            $hasClass = true;
                                            $classInfo = $schedule;
                                            break;
                                            }
                                            }
                                            }
                                            @endphp
                                            <td class="border border-gray-300 dark:border-gray-600 py-2 px-4 text-sm 
                                                    {{ $hasClass ? 'bg-green-100 dark:bg-green-800' : '' }}">
                                                @if($hasClass)
                                                <div class="text-xs">
                                                    <div class="font-medium">{{ $classInfo->subject->subject_name ?? 'N/A' }}</div>
                                                    <div>{{ $classInfo->section->section_level ?? 'N/A' }}</div>
                                                    <div>{{ $classInfo->room->room_number ?? 'N/A' }}</div>
                                                </div>
                                                @endif
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>