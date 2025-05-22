<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Manage Teachers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-maroon-200">
                <div class="p-6 text-gray-900">
                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="mb-6 px-4 py-3 bg-mustard-100 text-maroon-800 rounded">
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Teachers Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-maroon-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-maroon-800 uppercase tracking-wider">
                                        {{ __('ID Number') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-maroon-800 uppercase tracking-wider">
                                        {{ __('Name') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-maroon-800 uppercase tracking-wider">
                                        {{ __('Email') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-maroon-800 uppercase tracking-wider">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($teachers as $teacher)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-maroon-800">
                                        {{ $teacher->id_number ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-maroon-800">
                                        {{ $teacher->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-maroon-800">
                                        {{ $teacher->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="openEditModal({{ json_encode($teacher) }})" class="text-maroon-600 hover:text-maroon-800 mr-3">
                                            <i class="fa-solid fa-pen-to-square mr-1"></i> {{ __('Edit') }}
                                        </button>
                                        <button onclick="confirmDelete({{ $teacher->id }})" class="text-red-600 hover:text-red-800">
                                            <i class="fa-solid fa-trash mr-1"></i> {{ __('Delete') }}
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-maroon-600">
                                        {{ __('No teachers found.') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($teachers->hasPages())
                    <div class="mt-6">
                        {{ $teachers->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75" onclick="closeModal()"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-maroon-200">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-maroon-800 mb-4">
                        {{ __('Edit Teacher') }}
                    </h3>
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="edit_id_number" class="block text-sm font-medium text-maroon-800 mb-1">
                                {{ __('ID Number') }}
                            </label>
                            <input type="text" name="id_number" id="edit_id_number"
                                class="w-full px-3 py-2 border border-maroon-200 rounded-md shadow-sm focus:outline-none focus:ring-mustard-500 focus:border-mustard-500">
                        </div>

                        <div class="mb-4">
                            <label for="edit_name" class="block text-sm font-medium text-maroon-800 mb-1">
                                {{ __('Name') }} *
                            </label>
                            <input type="text" name="name" id="edit_name" required
                                class="w-full px-3 py-2 border border-maroon-200 rounded-md shadow-sm focus:outline-none focus:ring-mustard-500 focus:border-mustard-500">
                        </div>

                        <div class="mb-4">
                            <label for="edit_email" class="block text-sm font-medium text-maroon-800 mb-1">
                                {{ __('Email') }} *
                            </label>
                            <input type="email" name="email" id="edit_email" required
                                class="w-full px-3 py-2 border border-maroon-200 rounded-md shadow-sm focus:outline-none focus:ring-mustard-500 focus:border-mustard-500">
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" onclick="closeModal()"
                                class="px-4 py-2 border border-maroon-200 rounded-md text-sm font-medium text-maroon-800 hover:bg-maroon-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mustard-500">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-maroon-600 hover:bg-maroon-700 text-white rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mustard-500 transition duration-200">
                                {{ __('Update') }}
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
                                {{ __('Delete Teacher') }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-maroon-600">
                                    {{ __('Are you sure you want to delete this teacher? This action cannot be undone.') }}
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
        // Edit Modal functions
        function openEditModal(teacher) {
            document.getElementById('editForm').action = `/users/admin/teachers/${teacher.id}`;
            document.getElementById('edit_id_number').value = teacher.id_number || '';
            document.getElementById('edit_name').value = teacher.name;
            document.getElementById('edit_email').value = teacher.email;

            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function confirmDelete(id) {
            document.getElementById('deleteForm').action = `/users/admin/teachers/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target === document.getElementById('editModal')) {
                closeModal();
            }
            if (event.target === document.getElementById('deleteModal')) {
                closeDeleteModal();
            }
        }
    </script>
</x-app-layout>