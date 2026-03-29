<x-layout>
    @section('title', 'category' . $category->name)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <a href="{{ route('categories.index') }}"
            class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-blue font-medium text-sm mb-4 transition">
            <i class="fa-solid fa-arrow-left"></i>Back to Categories
        </a>

        <div
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-xl border border-gray-200">
            <div class="flex items-center gap-4">
                <div class="bg-blue-50 text-brand-blue p-3 rounded-lg border border-blue-100">
                    <i class="fa-solid fa-layer-group text-2xl"></i>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h1>
            <p class="text-sm text-gray-500 mt-1">Manage and track all issues reported</p>
        </div>
        <button
            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-lg transition text-sm flex item-center gap-2">
            <i class="fa-solid fa-pen"></i> Edit Category
        </button>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Issues</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
                <i class="fa-solid fa-hashtag"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-yellow-200 shadow-sm flex items-center justify-between">
            <p class="text-xs font-bold text-yellow-600 uppercase tracking-wider"> Pending Dispatch</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['pending'] }}</p>
            <div class="w-10 h-10 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-500">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-blue-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-brand-blue uppercase tracking-wider">Active Work</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['in_progress'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-brand-blue">
                <i class="fa-solid fa-person-digging"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-green-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Resolved</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['resolved'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-500">
                <i class="fa-solid fa-check-double"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-list text-gray-500"></i> Issues in this Category
            </h3>
        </div>
        @if ($complaints->isEmpty())
            <div class="p-12 text-center text-gray-500 flex flex-col items-center ">
                <i class="fa-regular fa-folder-open text-5xl text-gray-300 mb-4"></i>
                <p class="text-lg font-bold text-gray-700">No issues found.</p>
                <p class="text-sm">There are currently no complaints filed under this category.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th scope="col" class="px-6 py-4 font-bold ">Ticket ID</th>
                            <th scope="col" class="px-6 py-4 font-bold ">Title</th>
                            <th scope="col" class="px-6 py-4 font-bold ">Status</th>
                            <th scope="col" class="px-6 py-4 font-bold ">Submitted Date</th>
                            <th scope="col" class="px-6 py-4 font-bold ">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($complaints as $complaint)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-gray-800">#{{ $complaint->id }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                    {{ Str::limit($complaint->title, 40) }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $badgeClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'in_progress' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'under_review' => 'bg-purple-100 text-purple-800 border-purple-200',
                                            'approved' => 'bg-green-100 text-green-800 border-green-200',
                                            'resolved' => 'bg-green-100 text-green-800 border-green-200',
                                            'responded' => 'bg-yellow-100 text-orange-800 border-orange-200',
                                            'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                        ];
                                        $class =
                                            $badgeClasses[$complaint->status] ??
                                            'bg-gray-100 text-gray-800 border-gray-200';
                                    @endphp
                                    <span
                                        class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded border {{ $class }}">
                                        {{ str_ireplace('_', ' ', $complaint->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $complaint->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="#"
                                        class="text-brand-blue hover:text-blue-800 text-sm font-bold transition flex items-center justify-end gap-1">
                                        View <i class="fa-solid fa-chevron-right text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $complaints->links() }}
            </div>
        @endif
    </div>
</x-layout>
