<x-layout>
    @section('title','Transaction History')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Your Complaint History</h2>

        <div class="relative ml-3 w-full">
            @forelse ($logs as $log)
            <div class="mb-8 ml-6">


            <span class="absolute flex items-center justify-center w-6 h-6 bg-brand-blue rounded-full -left-3 ring-8 ring-[#f3f4f6]">
                <i class="fa-solid fa-clock text-white text-xs"></i>
            </span>

            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-start justify-between gap-4">
                <div>
                    <h3 class="mb-1 text-lg font-semibold text-gray-900">{{ $log->title }}</h3>
                    <time class="block mb-2 text-sm font-normal leading-none text-gray-400">
                        {{ $log->created_at->format('M j, Y - g:i A') }} (Complaint #{{ $log->complaint_id }})
                    </time>
                    <p class="text-base font-normal text-gray-500">{{ $log->description }}</p>
                </div>

                <div>
                    <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full
                        @if($log->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($log->status === 'in_progress') bg-blue-100 text-blue-800
                        @elseif($log->status === 'resolved') bg-green-100 text-green-800
                        @elseif($log->status === 'rejected') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif ">
                    {{ str_replace('_', ' ', $log->status) }}
                    </span>
                    </div>
                </div>
            </div>
            @empty
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-32 text-center text-gray-500">
                    <i class="fa-solid fa-folder-open text-4xl mb-3 text-gray-300"></i>
                    <p>No transaction history found.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $logs->links() }}
        </div>

    </div>
</x-layout>
