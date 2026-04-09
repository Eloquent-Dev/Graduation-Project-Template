<x-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 w-full">
        <h2 class="text-2xl font-bold mb-6">Pending Job Title Approvals</h2>

        <div class="bg-white shadow-md rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 ">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Title</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Requested Title (Editable)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($employees as $employee)
                        <tr>
                            <td class="px-6 py-4">{{ $employee->user->name }}</td>
                            <td class="px-6 py-4 text-gray-700 text-bold">{{ $employee->job_title ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <form id="approve-from-{{ $employee->id }}" action="{{ route('admin.job-title.approve', $employee) }}" method="POST">
                                    @csrf
                                    <input type="text" name="job_title" value="{{ $employee->pending_job_title ?? '' }}"
                                     class="border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm p-2">
                                </form>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button type="submit" form="approve-from-{{ $employee->id }}" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                                    Approve</button>

                                <form action="{{ route('admin.job-title.reject', $employee) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded">
                                        Reject</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-clipboard-check text-4xl mb-3 text-gray-300"></i>
                                <p class="text-lg font-medium text-gray-900">No Pending Approvals.</p>
                                <p class="text-sm mt-1">You are all caught up! There are no job title changes requests at this time.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
