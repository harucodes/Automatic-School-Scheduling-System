<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            {{ __('Manage Sections') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-maroon-200">
                <div class="p-6 text-maroon-900">
                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="mb-6 px-4 py-3 bg-mustard-100 text-maroon-800 rounded border border-mustard-200">
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Create Section Button -->
                    <div class="flex justify-end mb-6">
                        <button onclick="openCreateModal()" class="px-4 py-2 bg-maroon-600 hover:bg-maroon-700 text-white rounded-lg transition duration-200">
                            <i class="fa-solid fa-plus mr-2"></i>{{ __('Create New Section') }}
                        </button>
                    </div>

                    <!-- Sections Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-maroon-200">
                            <thead class="bg-maroon-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium  text-maroon-800 uppercase tracking-wider">
                                        {{ __('Name') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium  text-maroon-800 uppercase tracking-wider">
                                        {{ __('Level') }}
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium  text-maroon-800 uppercase tracking-wider">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-maroon-200">
                                @forelse($sections as $section)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-maroon-800">
                                        {{ $section->section_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-maroon-800">
                                        {{ $section->section_level }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="openEditModal({{ json_encode($section) }})" class="text-maroon-600 hover:text-maroon-900 mr-3">
                                            {{ __('Edit') }}
                                        </button>
                                        <button onclick="confirmDelete({{ $section->id }})" class="text-mustard-600 hover:text-mustard-800">
                                            {{ __('Delete') }}
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-maroon-600">
                                        {{ __('No sections found.') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($sections->hasPages())
                    <div class="mt-6">
                        {{ $sections->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Section Modal -->
    <div id="sectionModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" aria-modal="true" role="dialog">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeModal()"></div>

            <!-- Modal container -->
            <div class="inline-block align-bottom bg-white rounded-xl shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full overflow-hidden border border-maroon-200/50">
                <!-- Modal header -->
                <div class="bg-maroon-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 id="modalTitle" class="text-xl font-semibold text-white"></h3>
                        <button type="button" onclick="closeModal()" class="text-white hover:text-mustard-300 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal body -->
                <div class="px-6 py-5">
                    <form id="sectionForm" method="POST">
                        @csrf
                        <input type="hidden" id="formMethod" name="_method" value="POST">
                        <input type="hidden" id="sectionId" name="id" value="">

                        <div class="space-y-5">
                            <!-- Section Name -->
                            <div>
                                <label for="section_name" class="block text-sm font-medium text-maroon-800 mb-1.5">
                                    {{ __('Section Name') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="section_name" id="section_name" required
                                        class="w-full px-4 py-2.5 text-maroon-800 bg-white border border-maroon-200 rounded-lg focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 placeholder-maroon-400 transition duration-200">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <i class="fas fa-users text-maroon-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Grade Level -->
                            <div>
                                <label for="section_level" class="block text-sm font-medium text-maroon-800 mb-1.5">
                                    {{ __('Grade Level') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="section_level" id="section_level" required
                                        class="w-full px-4 py-2.5 text-maroon-800 bg-white border border-maroon-200 rounded-lg focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 placeholder-maroon-400 transition duration-200 appearance-none pr-10">
                                        <option value="">{{ __('Select Grade Level') }}</option>
                                        <option value="1st Year">1st Year College</option>
                                        <option value="2nd Year">2nd Year College</option>
                                        <option value="3rd Year">3rd Year College</option>
                                        <option value="4th Year">4th Year College</option>
                                        <option value="5th Year">5th Year College</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <i class="fas fa-layer-group text-maroon-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="mt-8 flex justify-end space-x-3">
                            <button type="button" onclick="closeModal()"
                                class="px-5 py-2.5 border border-maroon-200 rounded-lg text-sm font-medium text-maroon-800 hover:bg-maroon-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-maroon-500 transition duration-200">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit"
                                class="px-5 py-2.5 bg-gradient-to-r from-maroon-600 to-maroon-700 hover:from-maroon-700 hover:to-maroon-800 text-white rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-maroon-500 shadow-md transition duration-200 flex items-center">
                                <i class="fas fa-save mr-2"></i> {{ __('Save') }}
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
                <div class="absolute inset-0 bg-gray-500  opacity-75" onclick="closeDeleteModal()"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-maroon-200">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-mustard-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-maroon-800">
                                {{ __('Delete Section') }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-maroon-600">
                                    {{ __('Are you sure you want to delete this section? This action cannot be undone.') }}
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
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-mustard-600 text-base font-medium text-white hover:bg-mustard-700  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mustard-500 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ __('Delete') }}
                        </button>
                    </form>
                    <button type="button" onclick="closeDeleteModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-maroon-300 shadow-sm px-4 py-2 bg-white  text-base font-medium text-maroon-800 hover:bg-maroon-50  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-maroon-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Create New Section';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('sectionForm').action = '{{ route("admin.sections.store") }}';
            document.getElementById('sectionId').value = '';
            document.getElementById('section_name').value = '';
            document.getElementById('section_level').value = '';

            document.getElementById('sectionModal').classList.remove('hidden');
        }

        function openEditModal(section) {
            document.getElementById('modalTitle').textContent = 'Edit Section';
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('sectionForm').action = `/users/admin/sections/${section.id}`;
            document.getElementById('sectionId').value = section.id;
            document.getElementById('section_name').value = section.section_name;
            document.getElementById('section_level').value = section.section_level;

            document.getElementById('sectionModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('sectionModal').classList.add('hidden');
        }

        function confirmDelete(id) {
            document.getElementById('deleteForm').action = `/users/admin/sections/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target === document.getElementById('sectionModal')) {
                closeModal();
            }
            if (event.target === document.getElementById('deleteModal')) {
                closeDeleteModal();
            }
        }
    </script>
</x-app-layout>