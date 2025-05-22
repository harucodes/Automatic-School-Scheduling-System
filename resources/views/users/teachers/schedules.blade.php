<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Teacher Schedule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-maroon-200">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-maroon-800">Your Teaching Schedule</h3>
                        <a href="{{ route('teacher.schedule.export') }}"
                            class="px-4 py-2 bg-maroon-600 text-white rounded hover:bg-maroon-700 transition">
                            <i class="fa-solid fa-file-excel" aria-hidden="true"></i>
                            Export to Excel
                        </a>
                    </div>

                    <!-- Table View -->
                    <div class="mb-8">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white rounded-lg">
                                <thead>
                                    <tr class="bg-maroon-100">
                                        <th class="py-3 px-4 text-left text-maroon-800">Day</th>
                                        <th class="py-3 px-4 text-lef text-maroon-800t">Time</th>
                                        <th class="py-3 px-4 text-left text-maroon-800">Subject</th>
                                        <th class="py-3 px-4 text-left text-maroon-800">Section</th>
                                        <th class="py-3 px-4 text-left text-maroon-800">Room</th>
                                        <th class="py-3 px-4 text-left text-maroon-800">Students</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schedules as $schedule)
                                    <tr class="border-b border-maroon-100 hover:bg-maroon-50">
                                        <td class="py-3 px-4 text-maroon-800">{{ ucfirst($schedule->day) }}</td>
                                        <td class="py-3 px-4 text-maroon-800">
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} -
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                        </td>
                                        <td class="py-3 px-4 text-maroon-800">{{ $schedule->subject->subject_name ?? 'N/A' }}</td>
                                        <td class="py-3 px-4 text-maroon-800">{{ $schedule->section->section_level ?? 'N/A' }}</td>
                                        <td class="py-3 px-4 text-maroon-800">{{ $schedule->room->room_number ?? 'N/A' }}</td>
                                        <td class="py-3 px-4 text-maroon-800">{{ $schedule->students->count() }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="py-4 px-4 text-center  text-maroon-600">No teaching schedules found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Spreadsheet-like View -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium mb-4  text-maroon-800">Weekly Schedule Overview</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white rounded-lg border-collapse">
                                <thead>
                                    <tr>
                                        <th class="border border-maroon-200 py-2 px-4 bg-maroon-100 text-maroon-800">Time</th>
                                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                        <th class="border border-maroon-200 py-2 px-4 bg-maroon-100 text-maroon-800">{{ $day }}</th>
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
                                            <td class="border border-maroon-200 py-2 px-4 text-sm text-maroon-800">{{ $time }}</td>
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
                                            <td class="border border-maroon-200 py-2 px-4 text-sm 
                                                    {{ $hasClass ? 'bg-mustard-100' : '' }}">
                                                @if($hasClass)
                                                <div class="text-xs text-maroon-800">
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