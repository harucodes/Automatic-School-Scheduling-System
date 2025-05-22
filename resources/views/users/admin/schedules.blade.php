<x-app-layout>
<x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Manage Schedules For Teachers') }}
        </h2>
        <a href="{{ url('/users/admin/student-schedules') }}"
            class="inline-flex items-center px-4 py-2 bg-maroon-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-maroon-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mustard-500 transition">
            <i class="fa-solid fa-calendar-days mr-2"></i>{{ __('Manage Student Schedules') }}
        </a>
    </div>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-maroon-200">
            <div class="p-6 text-gray-900">
                <!-- Success Message -->
                @if(session('success'))
                <div class="mb-6 px-4 py-3 bg-mustard-100 text-maroon-800 rounded">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Calendar Navigation -->
                <div class="flex justify-between items-center mb-4">
                    <button id="prevMonth" class="px-3 py-1 rounded-md bg-maroon-100 hover:bg-maroon-200 text-maroon-800">
                        &lt; Previous
                    </button>
                    <h2 id="currentMonth" class="text-xl font-semibold text-maroon-800"></h2>
                    <button id="nextMonth" class="px-3 py-1 rounded-md bg-maroon-100 hover:bg-maroon-200 text-maroon-800">
                        Next &gt;
                    </button>
                </div>

                <!-- Create Schedule Button -->
                <div class="flex justify-end mb-6">
                    <button onclick="openCreateModal()" class="px-4 py-2 bg-maroon-600 hover:bg-maroon-700 text-white rounded-lg transition duration-200">
                        <i class="fa-solid fa-plus mr-2"></i> {{ __('Create New Schedule') }}
                    </button>
                </div>

                <!-- Calendar -->
                <div id="calendar" class="grid grid-cols-7 gap-1">
                    <!-- Day headers -->
                    <div class="text-center font-semibold py-2 text-maroon-800">Sun</div>
                    <div class="text-center font-semibold py-2 text-maroon-800">Mon</div>
                    <div class="text-center font-semibold py-2 text-maroon-800">Tue</div>
                    <div class="text-center font-semibold py-2 text-maroon-800">Wed</div>
                    <div class="text-center font-semibold py-2 text-maroon-800">Thu</div>
                    <div class="text-center font-semibold py-2 text-maroon-800">Fri</div>
                    <div class="text-center font-semibold py-2 text-maroon-800">Sat</div>

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
            <div class="absolute inset-0 bg-gray-500 opacity-75" onclick="closeDayModal()"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-maroon-200">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 id="dayModalTitle" class="text-lg leading-6 font-medium text-maroon-800 mb-4"></h3>

                <div class="mb-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-maroon-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-maroon-800 uppercase tracking-wider">
                                        {{ __('Time') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-maroon-800 uppercase tracking-wider">
                                        {{ __('Subject') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-maroon-800 uppercase tracking-wider">
                                        {{ __('Teacher') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-maroon-800 uppercase tracking-wider">
                                        {{ __('Section') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-maroon-800 uppercase tracking-wider">
                                        {{ __('Room') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-maroon-800 uppercase tracking-wider">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="dayScheduleBody" class="bg-white divide-y divide-gray-200">
                                <!-- Will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeDayModal()"
                        class="px-4 py-2 border border-maroon-200 rounded-md text-sm font-medium text-maroon-800 hover:bg-maroon-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mustard-500">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="scheduleModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75" onclick="closeModal()"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-maroon-200">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 id="modalTitle" class="text-lg leading-6 font-medium text-maroon-800 mb-4"></h3>
                <form id="scheduleForm" method="POST">
                    @csrf
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    <input type="hidden" id="scheduleId" name="id" value="">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="subject_id" class="block text-sm font-medium text-maroon-800 mb-1">
                                {{ __('Subject') }} *
                            </label>
                            <select name="subject_id" id="subject_id" required
                                class="w-full px-3 py-2 border border-maroon-200 rounded-md shadow-sm focus:outline-none focus:ring-mustard-500 focus:border-mustard-500">
                                <option value="">{{ __('Select Subject') }}</option>
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_name }} ({{ $subject->subject_code }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="user_teacher_id" class="block text-sm font-medium text-maroon-800 mb-1">
                                {{ __('Teacher') }} *
                            </label>
                            <select name="user_teacher_id" id="user_teacher_id" required
                                class="w-full px-3 py-2 border border-maroon-200 rounded-md shadow-sm focus:outline-none focus:ring-mustard-500 focus:border-mustard-500">
                                <option value="">{{ __('Select Teacher') }}</option>
                                @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="section_id" class="block text-sm font-medium text-maroon-800 mb-1">
                                {{ __('Section') }} *
                            </label>
                            <select name="section_id" id="section_id" required
                                class="w-full px-3 py-2 border border-maroon-200 rounded-md shadow-sm focus:outline-none focus:ring-mustard-500 focus:border-mustard-500">
                                <option value="">{{ __('Select Section') }}</option>
                                @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->section_name }} ({{ $section->section_level }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="room_id" class="block text-sm font-medium text-maroon-800 mb-1">
                                {{ __('Room') }} *
                            </label>
                            <select name="room_id" id="room_id" required
                                class="w-full px-3 py-2 border border-maroon-200 rounded-md shadow-sm focus:outline-none focus:ring-mustard-500 focus:border-mustard-500">
                                <option value="">{{ __('Select Room') }}</option>
                                @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="day" class="block text-sm font-medium text-maroon-800 mb-1">
                                {{ __('Day') }} *
                            </label>
                            <select name="day" id="day" required
                                class="w-full px-3 py-2 border border-maroon-200 rounded-md shadow-sm focus:outline-none focus:ring-mustard-500 focus:border-mustard-500">
                                <option value="">{{ __('Select Day') }}</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                        </div>
                        <input type="hidden" id="original_start_time" value="">
                        <input type="hidden" id="original_end_time" value="">
                        <input type="hidden" id="original_day" value="">

                        <div class="mb-4">
                            <label for="start_time" class="block text-sm font-medium text-maroon-800 mb-1">
                                {{ __('Start Time') }} *
                            </label>
                            <input type="time" name="start_time" id="start_time" required
                                class="w-full px-3 py-2 border border-maroon-200 rounded-md shadow-sm focus:outline-none focus:ring-mustard-500 focus:border-mustard-500">
                        </div>

                        <div class="mb-4">
                            <label for="end_time" class="block text-sm font-medium text-maroon-800 mb-1">
                                {{ __('End Time') }} *
                            </label>
                            <input type="time" name="end_time" id="end_time" required
                                class="w-full px-3 py-2 border border-maroon-200 rounded-md shadow-sm focus:outline-none focus:ring-mustard-500 focus:border-mustard-500">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 border border-maroon-200 rounded-md text-sm font-medium text-maroon-800 hover:bg-maroon-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mustard-500">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-maroon-600 hover:bg-maroon-700 text-white rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mustard-500 transition duration-200">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75" onclick="closeDeleteModal()"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-maroon-200">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-maroon-800">
                            {{ __('Delete Schedule') }}
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                {{ __('Are you sure you want to delete this schedule? This action cannot be undone.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Delete') }}
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-maroon-200 shadow-sm px-4 py-2 bg-white text-base font-medium text-maroon-800 hover:bg-maroon-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mustard-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    {{ __('Cancel') }}
                </button>
            </div>
        </div>
    </div>
</div>
    <script>
        // Calendar variables
        let currentDate = new Date();
        let schedules = @json($schedules -> items());

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
        });

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
                emptyDay.className = 'h-24 p-1 border border-maroon-200';
                calendarEl.appendChild(emptyDay);
            }

            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayEl = document.createElement('div');
                dayEl.className = 'h-24 p-1 border border-maroon-200  overflow-y-auto';

                const dayHeader = document.createElement('div');
                dayHeader.className = 'text-right font-semibold';
                dayHeader.textContent = day;
                dayEl.appendChild(dayHeader);

                // Find schedules for this day
                const dayName = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][
                    new Date(currentDate.getFullYear(), currentDate.getMonth(), day).getDay()
                ];

                const daySchedules = schedules.filter(schedule => schedule.day === dayName);

                // Add schedule indicators
                daySchedules.forEach(schedule => {
                    const scheduleEl = document.createElement('div');
                    scheduleEl.className = 'text-xs p-1 mb-1 rounded bg-mustard-600 text-maroon-800 cursor-pointer hover:bg-maroon-200 ';
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
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-maroon-800 ">
                        No schedules for this day
                    </td>
                `;
                bodyEl.appendChild(row);
            } else {
                schedules.forEach(schedule => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-maroon-800 ">
                            ${formatTime(schedule.start_time)} - ${formatTime(schedule.end_time)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-maroon-800 ">
                            ${schedule.subject.subject_name}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-maroon-800 ">
                            ${schedule.teacher.name}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-maroon-800 ">
                            ${schedule.section.section_name}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-maroon-800 ">
                            ${schedule.room.room_number}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="openEditModal(${JSON.stringify(schedule).replace(/"/g, '&quot;')})" class="text-maroon-600 hover:text-maroon-900 mr-3">
                                {{ __('Edit') }}
                            </button>
                            <button onclick="confirmDelete(${schedule.id})" class="text-mustard-600 hover:text-mustard-800">
                                {{ __('Delete') }}
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
        document.getElementById('scheduleForm').addEventListener('submit', function(e) {
            const originalStart = document.getElementById('original_start_time').value;
            const originalEnd = document.getElementById('original_end_time').value;
            const originalDay = document.getElementById('original_day').value;

            const currentStart = document.getElementById('start_time').value;
            const currentEnd = document.getElementById('end_time').value;
            const currentDay = document.getElementById('day').value;

            const isDayChanged = originalDay !== currentDay;
            const isTimeChanged = originalStart !== currentStart || originalEnd !== currentEnd;

            if (isDayChanged && !isTimeChanged) {
                e.preventDefault();
                alert('Please also update the start and end time when changing the day.');
            }
        });
        // Create/Edit Modal functions
        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Create New Schedule';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('scheduleForm').action = '{{ route("admin.schedules.store") }}';
            document.getElementById('scheduleId').value = '';
            document.getElementById('subject_id').value = '';
            document.getElementById('user_teacher_id').value = '';
            document.getElementById('section_id').value = '';
            document.getElementById('room_id').value = '';
            document.getElementById('day').value = '';
            document.getElementById('start_time').value = '';
            document.getElementById('end_time').value = '';

            document.getElementById('scheduleModal').classList.remove('hidden');
        }

        function openEditModal(schedule) {
            document.getElementById('modalTitle').textContent = 'Edit Schedule';
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('scheduleForm').action = `/users/admin/schedules/${schedule.id}`;
            document.getElementById('scheduleId').value = schedule.id;

            // Set form values
            document.getElementById('subject_id').value = schedule.subject_id;
            document.getElementById('user_teacher_id').value = schedule.user_teacher_id;
            document.getElementById('section_id').value = schedule.section_id;
            document.getElementById('room_id').value = schedule.room_id;
            document.getElementById('day').value = schedule.day;
            document.getElementById('start_time').value = schedule.start_time;
            document.getElementById('end_time').value = schedule.end_time;

            // Save original values
            document.getElementById('original_start_time').value = schedule.start_time;
            document.getElementById('original_end_time').value = schedule.end_time;
            document.getElementById('original_day').value = schedule.day;

            // Show modal
            document.getElementById('scheduleModal').classList.remove('hidden');
        }


        function closeModal() {
            document.getElementById('scheduleModal').classList.add('hidden');
        }

        function confirmDelete(id) {
            document.getElementById('deleteForm').action = `/users/admin/schedules/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target === document.getElementById('dayModal')) {
                closeDayModal();
            }
            if (event.target === document.getElementById('scheduleModal')) {
                closeModal();
            }
            if (event.target === document.getElementById('deleteModal')) {
                closeDeleteModal();
            }
        }
    </script>
</x-app-layout>