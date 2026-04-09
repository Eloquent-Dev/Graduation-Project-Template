<x-layout>
    @section('title', 'My Complaints')

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8 w-full">
        <div class="flex justify-between items-center border-b border-gray-200 pb-5">
            <div>
                <h2 class="text-3xl font-bold text-brand-dark">My Complaints</h2>
                <p class="text-gray-500 text-sm">Track the status of the issues you have submitted.</p>
            </div>
            <a href="{{ route('complaints.create') }}" class="bg-brand-orange hover:bg-orange-600 text-white px-4 py-2 rounded shadow transition text-sm font-bold flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> New Complaint
            </a>
        </div>

        @if($complaints->isEmpty())
            <div class="bg-white p-12 rounded-xl shadow-sm border border-gray-100 max-w-full mx-auto mt-4 text-center">
                <div class="w-16 h-16 bg-blue-50 text-brand-blue rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-folder-open text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">No complaints yet</h3>
                <p class="text-gray-500 text-sm mt-1">You haven't submitted any issues yet.</p>
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Issue Title</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Submitted On</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-500">
                            @foreach ($complaints as $complaint)
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'in_progress' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'resolved' => 'bg-green-100 text-green-800 border-green-200',
                                        'under_review' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        'reopened' => 'bg-red-100 text-red-800 border-red-200',
                                        'closed' => 'bg-gray-100 text-gray-800 border-gray-200'
                                    ];
                                    $colorClass = $statusColors[$complaint->status] ?? 'bg-gray-100 text-gray-800'
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-bold text-gray-800">{{ $complaint->title }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-600">{{ $complaint->category->name }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $colorClass }}">
                                            {{ str_replace('_',' ',strtoupper($complaint->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $complaint->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('complaints.show',$complaint->id) }}" class="text-brand-blue hover:text-blue-800 font-bold text-sm">
                                            View Details <i class="fa-solid fa-arrow-right ml-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-layout>
