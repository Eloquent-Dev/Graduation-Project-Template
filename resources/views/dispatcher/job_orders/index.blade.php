<x-layout>
    @section('title', 'Job Orders Queue')
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8 w-full">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 border-b border-gray-200 pb-5">
            <div>
                <h2 class="text-3xl font-bold text-brand-dark">Job Orders Queue</h2>
                <p class="text-gray-500 text-sm mt-1">Assign field teams to municipal work orders.</p>
            </div>

            <div>
                <i class="fa-solid fa-list-check mr-2"></i> Active Orders: {{ $jobOrders->total() }}
            </div>
        </div>

        @if($jobOrders->isEmpty())
            <div class="bg-white p-16 rounded-xl shadow-sm border border-gray-100 text-center max-w-2xl mx-auto mt-10">
                <div class="w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-clipboard-check text-3xl"></i>
                </div>

                <h3 class="text-xl font-bold text-gray-800 mb-2">Queue is Empty</h3>
                <p class="text-gray-500 text-sm">There are no pending job orders requiring dispatch.</p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-gray-50 border-b boder-gray-100 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-4">Job Order ID</th>
                                <th class="px-6 py-4">Priority</th>
                                <th class="px-6 py-4">Linked Issue</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Assigned Team</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @foreach($jobOrders as $job)
                                @php
                                    $priorityColors = [
                                        'high' => 'bg-red-100 text-red-800 border-red-200 animate-pulse',
                                        'medium' => 'bg-orange-100 text-orange-800 border-orange-200',
                                        'low' => 'bg-green-100 text-green-800 border-green-200'
                                    ];
                                    $pColor = $priorityColors[$job->priority] ?? 'bg-gray-100 text-gray-800';

                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'in_progress' => 'bg-blue-100 text-blue-800',
                                        'reopened' => 'bg-green-100 text-green-800'
                                    ];
                                    $sColor = $statusColors[$job->status] ?? 'bg-gray-100 text-gray-800'
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm font-bold text-gray-800">#JO-{{ $job->id }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold border {{ $pColor }}">
                                            <i class="fa-solid fa-flag mr-1"></i> {{ strtoupper($job->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-bold text-gray-800">{{ $job->complaint->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $job->complaint->category->name }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded text-xs font-bold {{ $sColor }}">
                                            {{ str_replace('_',' ', strtoupper($job->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        @if($job->workers->count() > 0)
                                            <div class="flex -space-x-2 overflow-hidden">
                                                @foreach ($job->workers->take(3) as $worker)
                                                    <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-brand-blue text-white flex items-center justify-center text-xs font-bold" title="{{ $worker->user->name }}">
                                                        {{ substr($worker->user->name,0,1) }}
                                                    </div>
                                                @endforeach
                                                @if($job->workers->count() > 3)
                                                    <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-gray-200 text-gray-600 flex items-center justify-center text-xs font-bold">
                                                        +{{ $job->workers->count() - 3 }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Unassigned</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('dispatcher.job_orders.show', $job->id) }}" class="bg-brand-blue hover:bg-blue-800 text-white px-3 py-1.5 rounded text-xs font-bold transition shadow-sm">
                                            Dispatch <i class="fa-solid fa-truck-fast ml-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-100">
                    {{ $jobOrders->links() }}
                </div>
            </div>
        @endif
    </div>
</x-layout>
