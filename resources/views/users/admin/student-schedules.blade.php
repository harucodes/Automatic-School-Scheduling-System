<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Student Schedules') }}
        </h2>
    </x-slot>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <!-- jQuery (required for Toastr) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Success Message -->
                    <div x-data="{
        showSuccess: false,
        showError: false,
        successMessage: '',
        errorMessage: '',
        closeSuccess() {
            this.showSuccess = false;
        },
        closeError() {
            this.showError = false;
        }
    }"
                        x-init="
        @if(Session::has('success'))
            showSuccess = true;
            successMessage = '{{ Session::get('success') }}';
            setTimeout(() => showSuccess = false, 5000);
        @endif
        @if(Session::has('error') || $errors->any())
            showError = true;
            errorMessage = '{{ Session::get('error', $errors->first()) }}';
            setTimeout(() => showError = false, 5000);
        @endif
    ">
                        <!-- Success Alert -->
                        <div x-show="showSuccess"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-10"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 translate-x-10"
                            class="fixed z-50 top-5 right-5 w-80">
                            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg shadow-lg overflow-hidden">
                                <div class="p-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3 w-0 flex-1 pt-0.5">
                                            <p class="text-sm font-medium text-green-800" x-text="successMessage"></p>
                                        </div>
                                        <div class="ml-4 flex-shrink-0 flex">
                                            <button @click="closeSuccess" class="inline-flex text-green-500 hover:text-green-700 focus:outline-none">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-green-100 px-4 py-2">
                                    <div class="h-1 w-full bg-green-200 rounded-full overflow-hidden">
                                        <div x-show="showSuccess"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="w-0"
                                            x-transition:enter-end="w-full"
                                            class="h-full bg-green-500"
                                            style="animation: progress 5s linear forwards;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Error Alert -->
                        <div x-show="showError"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-10"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 translate-x-10"
                            class="fixed z-50 top-5 right-5 w-80">
                            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow-lg overflow-hidden">
                                <div class="p-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3 w-0 flex-1 pt-0.5">
                                            <p class="text-sm font-medium text-red-800" x-text="errorMessage"></p>
                                        </div>
                                        <div class="ml-4 flex-shrink-0 flex">
                                            <button @click="closeError" class="inline-flex text-red-500 hover:text-red-700 focus:outline-none">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-red-100 px-4 py-2">
                                    <div class="h-1 w-full bg-red-200 rounded-full overflow-hidden">
                                        <div x-show="showError"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="w-0"
                                            x-transition:enter-end="w-full"
                                            class="h-full bg-red-500"
                                            style="animation: progress 5s linear forwards;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        @keyframes progress {
                            0% {
                                width: 100%;
                            }

                            100% {
                                width: 0%;
                            }
                        }
                    </style>
                    <script>
                        new TomSelect("#studentSelect", {
                            create: false,
                            sortField: {
                                field: "text",
                                direction: "asc"
                            },
                            placeholder: "Search or select a student..."
                        });
                    </script>

                    <!-- Student Selection -->
                    <!-- Enhanced Select Field -->
                    <div class="mb-6 w-full max-w-md">
                        <label for="studentSelect" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">
                            {{ __('Select Student') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="studentSelect" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 transition ease-in-out duration-150">
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
                            <i class="fa-solid fa-calendar-plus mr-2"></i>{{ __('Assign Schedule') }}
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