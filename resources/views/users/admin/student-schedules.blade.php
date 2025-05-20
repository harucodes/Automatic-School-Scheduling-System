<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Student Schedules') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="mb-6 px-4 py-3 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded">
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Student Selection -->
                    <div class="mb-6">
                        <label for="studentSelect" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Select Student') }} *
                        </label>
                        <select id="studentSelect" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200">
                            <option value="">{{ __('Select a student') }}</option>
                            @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->id_number ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Calendar Navigation -->
                    <div class="flex justify-between items-center mb-4">
                        <button id="prevMonth" class="px-3 py-1 rounded-md bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600">
                            &lt; Previous
                        </button>
                        <h2 id="currentMonth" class="text-xl font-semibold"></h2>
                        <button id="nextMonth" class="px-3 py-1 rounded-md bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600">
                            Next &gt;
                        </button>
                    </div>

                    <!-- Assign Schedule Button -->
                    <div class="flex justify-end mb-6">
                        <button onclick="openAssignModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200">
                            {{ __('Assign Schedule') }}
                        </button>
                    </div>

                    <!-- Calendar -->
                    <div id="calendar" class="grid grid-cols-7 gap-1">
                        <!-- Day headers -->
                        <div class="text-center font-semibold py-2">Sun</div>
                        <div class="text-center font-semibold py-2">Mon</div>
                        <div class="text-center font-semibold py-2">Tue</div>
                        <div class="text-center font-semibold py-2">Wed</div>
                        <div class="text-center font-semibold py-2">Thu</div>
                        <div class="text-center font-semibold py-2">Fri</div>
                        <div class="text-center font-semibold py-2">Sat</div>

                        <!-- Calendar days will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Day Schedule Modal -->
    <div id="dayModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75" onclick="closeDayModal()"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 id="dayModalTitle" class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-200 mb-4"></h3>

                    <div class="mb-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Time') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Subject') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Teacher') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Section') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Room') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="dayScheduleBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <!-- Will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeDayModal()"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('Close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Schedule Modal -->
    <div id="assignModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75" onclick="closeAssignModal()"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-200 mb-4">
                        {{ __('Assign Schedule to Student') }}
                    </h3>
                    <form id="assignForm" method="POST">
                        @csrf
                        <input type="hidden" id="studentId" name="user_student_id" value="">

                        <div class="mb-4">
                            <label for="assign_schedule_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('Schedule') }} *
                            </label>
                            <select name="schedule_id" id="assign_schedule_id" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200">
                                <option value="">{{ __('Select Schedule') }}</option>
                                @foreach($availableSchedules as $schedule)
                                <option value="{{ $schedule->id }}">
                                    {{ $schedule->subject->subject_name }} -
                                    {{ $schedule->day }} {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}-{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }} -
                                    {{ $schedule->section->section_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" onclick="closeAssignModal()"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                {{ __('Assign') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Remove Confirmation Modal -->
    <div id="removeModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75" onclick="closeRemoveModal()"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-200">
                                {{ __('Remove Schedule') }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Are you sure you want to remove this schedule from the student?') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form id="removeForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ __('Remove') }}
                        </button>
                    </form>
                    <button type="button" onclick="closeRemoveModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Calendar variables
        let currentDate = new Date();
        let currentStudentId = null;
        let studentSchedules = [];

        // Initialize calendar
        document.addEventListener('DOMContentLoaded', function() {
            renderCalendar();

            // Navigation buttons
            document.getElementById('prevMonth').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });

            document.getElementById('nextMonth').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });

            // Student selection
            document.getElementById('studentSelect').addEventListener('change', function() {
                currentStudentId = this.value;
                if (currentStudentId) {
                    fetchStudentSchedules(currentStudentId);
                } else {
                    studentSchedules = [];
                    renderCalendar();
                }
            });
        });

        // Fetch student schedules
        function fetchStudentSchedules(studentId) {
            console.log("Fetching schedules for student:", studentId); // Log before fetching

            fetch(`/api/student-schedules/${studentId}`)
                .then(response => response.json())
                .then(data => {
                    console.log("Fetched schedules:", data);
                    studentSchedules = data; // Assign to global variable
                    renderCalendar(); // Call render
                })
                .catch(error => console.error('Error fetching schedules:', error));
        }



        // Render calendar
        function renderCalendar() {
            const calendarEl = document.getElementById('calendar');
            const monthYearEl = document.getElementById('currentMonth');

            // Clear existing calendar days (except headers)
            while (calendarEl.children.length > 7) {
                calendarEl.removeChild(calendarEl.lastChild);
            }

            // Set month/year header
            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            monthYearEl.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

            // Get first day of month and total days in month
            const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
            const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();

            // Add empty cells for days before the first day of the month
            for (let i = 0; i < firstDay; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'h-24 p-1 border border-gray-200 dark:border-gray-700';
                calendarEl.appendChild(emptyDay);
            }

            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayEl = document.createElement('div');
                dayEl.className = 'h-24 p-1 border border-gray-200 dark:border-gray-700 overflow-y-auto';

                const dayHeader = document.createElement('div');
                dayHeader.className = 'text-right font-semibold';
                dayHeader.textContent = day;
                dayEl.appendChild(dayHeader);

                // Find schedules for this day
                const dayName = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][
                    new Date(currentDate.getFullYear(), currentDate.getMonth(), day).getDay()
                ];

                const daySchedules = studentSchedules.filter(schedule => schedule.day === dayName);

                // Add schedule indicators
                daySchedules.forEach(schedule => {
                    const scheduleEl = document.createElement('div');
                    scheduleEl.className = 'text-xs p-1 mb-1 rounded bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 cursor-pointer hover:bg-blue-200 dark:hover:bg-blue-800';
                    scheduleEl.textContent = `${schedule.subject.subject_name} (${formatTime(schedule.start_time)}-${formatTime(schedule.end_time)})`;
                    scheduleEl.addEventListener('click', () => openDayModal(dayName, daySchedules));
                    dayEl.appendChild(scheduleEl);
                });

                // Add click event to open day modal
                dayEl.addEventListener('click', function(e) {
                    if (e.target === dayHeader || e.target === dayEl) {
                        openDayModal(dayName, daySchedules);
                    }
                });

                calendarEl.appendChild(dayEl);
            }
        }

        // Format time to 12-hour format
        function formatTime(timeString) {
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            return hour > 12 ? `${hour - 12}:${minutes} PM` : `${hour}:${minutes} AM`;
        }

        // Day Modal functions
        function openDayModal(dayName, schedules) {
            document.getElementById('dayModalTitle').textContent = `Schedules for ${dayName}`;
            const bodyEl = document.getElementById('dayScheduleBody');
            bodyEl.innerHTML = '';

            if (schedules.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                        No schedules for this day
                    </td>
                `;
                bodyEl.appendChild(row);
            } else {
                schedules.forEach(schedule => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                            ${formatTime(schedule.start_time)} - ${formatTime(schedule.end_time)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                            ${schedule.subject.subject_name}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                            ${schedule.teacher.name}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                            ${schedule.section.section_name}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                            ${schedule.room.room_number}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="confirmRemove(${schedule.pivot.id})" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-500">
                                {{ __('Remove') }}
                            </button>
                        </td>
                    `;
                    bodyEl.appendChild(row);
                });
            }

            document.getElementById('dayModal').classList.remove('hidden');
        }

        function closeDayModal() {
            document.getElementById('dayModal').classList.add('hidden');
        }

        // Assign Modal functions
        function openAssignModal() {
            const studentId = document.getElementById('studentSelect').value;
            if (!studentId) {
                alert('Please select a student first');
                return;
            }

            document.getElementById('studentId').value = studentId;
            document.getElementById('assignForm').action = '{{ route("admin.student-schedules.store") }}';

            document.getElementById('assignModal').classList.remove('hidden');
        }

        function closeAssignModal() {
            document.getElementById('assignModal').classList.add('hidden');
        }

        // Remove Modal functions
        function confirmRemove(scheduleStudentId) {
            document.getElementById('removeForm').action = `/users/admin/student-schedules/${scheduleStudentId}`;
            document.getElementById('removeModal').classList.remove('hidden');
        }

        function closeRemoveModal() {
            document.getElementById('removeModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target === document.getElementById('dayModal')) {
                closeDayModal();
            }
            if (event.target === document.getElementById('assignModal')) {
                closeAssignModal();
            }
            if (event.target === document.getElementById('removeModal')) {
                closeRemoveModal();
            }
        }
    </script>
</x-app-layout>