<x-layout>
@section('title','My Completion Reports')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 w-full">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Completion Reports</h1>
            <p class="text-sm text-gray-500 mt-1">A list of all completion reports you have submitted.</p>
        </div>
        <div class="bg-blue-50 text-brand-blue border border-blue-200 px-4 py-2 rounded-lg shadow-sm flex items-center gap-3">
            <i class="fa-solid fa-chart-line text-lg"></i>
            <div><span class="block text-[10px] font-bold uppercase tracking-wider text-blue-500">Total Submitted</span>
            <span class="block text-lg font-bold leading-none">{{ $reports->total() }}</span>
            </div>
        </div>
        </div>
        <div class="bg-white rounded-x1 shadow-sm overflow-hidden border border-gray-200">
           @if ($reports->isEmpty())
           <div class="p-12 text-center text-gray-400 flex flex-col items-center">
               <i class="fa-solid fa-folder-open text-5xl mb-4 text-gray-300"></i>
               <p class="text-lg font-bold text-gray-600 ">No reports found</p>
               <p class="text-sm mt-1">You have not submitted any completion reports yet.</p>
           </div>
              @else
              <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th class="p-4 font-bold ">Job ID</th>
                            <th class="p-4 font-bold ">Task Description</th>
                            <th class="p-4 font-bold ">Submitted At</th>
                            <th class="p-4 font-bold ">Admin Status</th>
                            <th class="p-4 font-bold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($reports as $report)
                        <tr class="hover:bg-gray-50 transition group">
                            <td class="p-4 align-top">
                                <span class="font-bold text-gray-800">#JO-{{ $report->jobOrder->id }}</span>
                            </td>
                            <td class="p-4 align-top">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-brand-blue bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                                    {{ $report->jobOrder->complaint->category->name ?? 'uncategorized'}}
                                </span>
                                <p class="text-sm font-bold text-gray-900 mt-1.5">{{ $report->jobOrder->complaint->title }}</p>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $report->jobOrder->complaint->description }}</p>
                            </td>
                            <td class="p-4 align-top">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="fa-regular fa-calendar text-gray-400"></i>
                                    {{ $report->created_at->format('M d, Y') }}</div>

                                    <div class="text-xs text-gray-400 mt-1 ml-5">
                                        {{ $report->created_at->format('h:i A') }}
                                    </div>
                            </td>
                            <td class="p-4 align-top">
                                @php
                                    $status=$report -> jobOrder -> status;
                                @endphp
                                @if ($status === 'under_review')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-purple-400 text-xs font-bold rounded-md border border-purple-200">
                                        <i class="fa-solid fa-hourglass-half "></i>
                                        Under Review
                                    </span>
                                @elseif ($status === 'resolved')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-400 text-xs font-bold rounded-md border border-green-200">
                                        <i class="fa-solid fa-check-double "></i>
                                        Approved
                                    </span>
                                @elseif ($status === 'rejected')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-400 text-xs font-bold rounded-md border border-red-200">
                                        <i class="fa-solid fa-ban "></i>
                                        Rejected ( Invalid )
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-400 text-xs font-bold rounded-md border border-gray-200">
                                        {{ str_replace('_', ' ', $status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 align-top text-right">
                                <a href="{{ route('supervisor.reports.show', $report) }}"
                                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-white text-brand-blue hover:bg-blue-50 border border-blue-200 hover:border-blue-300 rounded-lg text-xs font-bold transition shadow-sm group">
                                    View Details <i class="fa-solid fa-arrow-right group-hover:translate-x-0.5 transition-transform"></i>
                                </a>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
              @if ($reports->hasPages())
                  <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                      {{ $reports->links() }}
                  </div>
              @endif
              @endif
        </div>
</div>
</x-layout>
