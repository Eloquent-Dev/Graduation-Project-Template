<x-layout>
    @section('title', 'Ticket #' . str_pad($complaint->id,5,'0', STR_PAD_LEFT) . ' - ' . $complaint->title)

    <div class="max-w-5xl mx-auto px-6 lg:px-8 py-8 w-full">
        <a href="{{ route('admin.users.complaints.index', $complaint->user_id) }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-blue font-medium text-sm mb-6 transition">
            <i class="fa-solid fa-arrow-left"></i> Back to Complaints
        </a>

        <div class="bg-linear-to-r from-brand-dark to-brand-blue rounded-xl shadow-lg border border-gray-800 overflow-hidden mb-6 flex flex-col sm:flex-row items-center justify-between p-6 gap-4">
            <div class="flex items-center gap-4 text-white w-full sm:w-auto">
                <div class="w-12 h-12 rounded-full bg-brand-orange flex items-center justify-center text-xl font-bold shadow-inner shrink-0">
                    {{ substr($complaint->user?->name,0,1) }}
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-bold mb-0.5">Submitted By</p>
                    <h3 class="text-lg font-bold">{{ $complaint->user?->name }} <span class="text-[10px] ml-2 px-2 py-0.5 bg-gray-700 rounded text-gray-300">{{ $complaint->user?->role }}</span></h3>
                    <p class="text-sm text-gray-300 mt-0.5 flex items-center flex-wrap gap-x-2">
                        <span><i class="fa-solid fa-envelope text-gray-500 mr-1"></i>{{ $complaint->user->email }}</span>
                        <span class="hidden sm:inline text-gray-600">|</span>
                        <span><i class="fa-solid fa-phone text-gray-500 mr-1"></i>{{ $complaint->user->phone ?? 'N/A' }}</span>
                    </p>
                </div>
            </div>
            <div class="shrink-0 w-full sm:w-auto">
                <a href="{{ route('admin.users.showProfile',$complaint->user_id) }}" class="block text-center px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white text-sm font-bold rounded-lg transition">
                    View Full Profile
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <div class="mb-2">
                        <span class="text-xs font-mono bg-gray-100 text-gray-600 px-2 py-1 rounded border border-gray-200">
                            Ticket #{{ str_pad($complaint->id,5,'0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold text-brand-dark">{{ $complaint->title }}</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Reported on {{ $complaint->created_at->format('F j, Y g:i A') }}
                    </p>
                </div>
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                        'in_progress' => 'bg-blue-100 text-blue-800 border-blue-200',
                        'under_review' => 'bg-purple-100 text-purple-800 border-purple-200',
                        'approved' => 'bg-green-100 text-green-800 border-green-200',
                        'resolved' => 'bg-gray-100 text-gray-800 border-gray-200',
                        'reopened' => 'bg-red-100 text-red-800 border-red-200',
                    ];

                    $ColorClass = $statusColors[$complaint->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                @endphp
                <div>
                    <span class="px-4 py-2 rounded-full text-sm font-bold border shadow-sm {{ $ColorClass }}">
                        Status: {{ str_replace('_', ' ', strtoupper($complaint->status)) }}
                    </span>
                    <p class="text-sm text-gray-500 mt-6">
                        Approved at {{ $complaint->approved_at ? Carbon\Carbon::parse($complaint->approved_at)->format('F j, Y \a\t g:i A') : 'N/A' }}
                    </p>
                    <p class="text-sm text-gray-500 mt-6">
                        Resolved at {{ $complaint->resolved_at ? Carbon\Carbon::parse($complaint->resolved_at)->format('F j, Y \a\t g:i A') : 'N/A' }}
                    </p>
                </div>

            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6 flex flex-col">
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Category</h4>
                        <p class="text-gray-800 font-medium bg-gray-50 inline-block px-4 py-2 rounded-lg border border-gray-200 shadow-sm">
                           <i class="fa-solid fa-tag text-brand-blue"></i> {{ $complaint->category->name ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="grow flex flex-col">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Citizen's Report</h4>
                        <div class="relative bg-blue-50/50 p-6 rounded-xl border border-blue-100 shadow-sm grow">
                            <i class="fa-solid fa-quote-left absolute top-4 left-4 text-blue-200 text-4xl z-0 opacity-50"></i>
                            <p class="text-gray-700 leading-relaxed relative z-10 pl-8 pt-2 text-sm md:text-base italic">
                                {{ $complaint->description }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Reported Location</h4>
                    <div id="readonly-map" class="w-full h-64 bg-gray-200 border-2 border-gray-200 rounded-lg shadow-inner"></div>

                    <a href="https://maps.google.com/?q={{ $complaint->latitude }},{{ $complaint->longitude }}" target="_blank" class="w-full bg-gray-50 hover:bg-gray-100 text-brand-blue font-bold py-3 px-4 rounded-b-xl transition flex items-center justify-center gap-2 text-sm border-2 border-gray-200 pointer shadow-sm group">
                        <i class="fa-solid fa-route text-brand-orange group-hover:scale-110 transition-transform"></i> View on Google Maps
                    </a>
                </div>
            </div>
            <div class="mt-10" x-data="{activeStage: 1}">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2 border-b pb-3">
                    <i class="fa-solid fa-list-ol text-brand-blue pl-2"></i> Complaint Lifecycle Stages
                </h3>
                <div class="space-y-4 pl-2 pr-2">
                    <div class="border border-gray-200 rounded-xl bg-white overflow-hidden shadow-sm">
                        <button @click="activeStage = activeStage === 1 ? null : 1" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition text-left">
                            <div class="flex items-center gap-4">
                                <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center font-bold border border-gray-200">
                                    1
                                </div>
                                <h4 class="font-bold text-gray-800">Submission Details</h4>
                            </div>
                            <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-200" :class="activeStage === 1 ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="activeStage === 1" x-transition class="p-6 border-t border-gray-200 bg-gray-50/50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Submitted By (Citizen)</span>
                                <span class="block text-gray-800 font-medium">{{ $complaint->user?->name }} </span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Submitted At</span>
                                <span class="block text-gray-800 font-medium">{{ $complaint->created_at->format('F j, Y g:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border border-gray-200 rounded-xl bg-white overflow-hidden shadow-sm">
                    <button @click="activeStage = activeStage === 2 ? null : 2" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition text-left">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full {{ ($complaint->approved_at || $complaint->rejected_at) ? 'bg-blue-100 text-blue-600 border-blue-200' : 'bg-gray-100 text-gray-600 border-gray-200' }} flex items-center justify-center font-bold">
                                2
                            </div>
                            <h4 class="font-bold text-gray-800">Administrative Review</h4>
                        </div>
                        <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-200" :class="activeStage === 2 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="activeStage === 2" x-transition class="p-6 border-t border-gray-200 bg-gray-50/50">
                        @if($complaint->approved_at)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Approved By</span>
                                <span class="block text-green-600 font-bold"><i class="fa-solid fa-check-circle mr-1"></i> {{ $complaint->approvedBy?->user?->name ?? 'System' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Approved At</span>
                                <span class="block text-gray-800 font-medium">{{ \Carbon\Carbon::parse($complaint->approved_at)->format('F j, Y \a\t g:i A') }}</span>
                            </div>
                        </div>
                        @elseif($complaint->rejected_at)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 ">
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Rejected By</span>
                                <span class="block text-red-600 font-bold"><i class="fa-solid fa-times-circle mr-1"></i> {{ $complaint->rejectedBy?->user?->name ?? 'System' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Rejected Reason</span>
                                <span class="block text-gray-800 font-medium">{{ $complaint->rejection_reason ?? 'No reason provided' }}</span>
                            </div>
                        </div>
                        @else
                        <p class="text-gray-500 italic text-sm"> This complaint has not been reviewed by an administrator yet .</p>
                        @endif
                    </div>
                </div>
                <div class="border border-gray-200 rounded-xl bg-white overflow-hidden shadow-sm ">
                    <button @click="activeStage = activeStage === 3 ? null : 3" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition text-left">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full {{ ($complaint->jobOrders->count() > 0) ? 'bg-yellow-100 text-yellow-600 border-yellow-200' : 'bg-gray-100 text-gray-600 border-gray-200' }} flex items-center justify-center font-bold">
                                3
                            </div>
                            <h4 class="font-bold text-gray-800">Dispatcher & Assignments</h4>
                        </div>
                        <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-200" :class="activeStage === 3 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="activeStage === 3" x-transition class="p-6 border-t border-gray-200 bg-gray-50/50">
                        @if($complaint->jobOrders->count() > 0)
                            <div class="space-y-6">
                                @foreach($complaint->jobOrders as $job)
                                    <div class="border border-gray-200 rounded-lg p-5 bg-white shadow-sm">
                                        <h5 class="text-sm font-bold text-gray-700 mb-4 border-b pb-2">Job Order #{{ $job->id}}</h5>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Dispatcher</span>
                                                <span class="block text-gray-800 font-medium"><i class="fa-solid fa-headset text-brand-orange mr-1"></i> {{ $job->assignedBy?->user?->name ?? 'System' }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Dispatched At</span>
                                                <span class="block text-gray-800 font-medium">{{ $job->assigned_at ? \Carbon\Carbon::parse($job->assigned_at)->format('F j, Y \a\t g:i A') : 'Pending' }}</span>
                                            </div>
                                            <div class="md:col-span-2 mt-2">
                                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Assigned Team</span>
                                                @foreach ($job->workers as $worker)
                                                    <span class="px-3 py-1 bg-brand-blue/10 text-brand-blue rounded-md text-xs font-bold border border-brand-blue/20">
                                                        <i class="fa-solid fa-user-helmet mr-1"></i> {{ $worker->user?->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                            </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic text-sm"> No job orders have been dispatched for this complaint yet. </p>
                        @endif
                    </div>
                </div>
                <div class="pl-2 pr-2 pt-4">
                    <div class="border-t border-gray-200 h-full absolute left-4 top-4"></div>
                <div class="border border-gray-200 rounded-xl bg-white overflow-hidden shadow-sm ">
                    <button @click="activeStage = activeStage === 4 ? null : 4" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition text-left">
                        <div class="flex items-center gap-4 ">
                            @php
                                $hasCompletion = false;
                                foreach($complaint->jobOrders as $job)
                                    if($job->completionReport) {
                                        $hasCompletion = true;
                                    }

                            @endphp
                            <div class="w-8 h-8 rounded-full  {{ $hasCompletion ? 'bg-blue-100 text-blue-600 border-blue-200' : 'bg-gray-100 text-gray-600 border-gray-200' }} flex items-center justify-center font-bold">
                                4
                            </div>
                            <h4 class="font-bold text-gray-800 ">Filed Execution & Completion</h4>
                        </div>
                        <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-200" :class="activeStage === 4 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="activeStage === 4" x-transition class="p-6 border-t border-gray-200 bg-gray-50/50">
                        @if($hasCompletion)
                            <div class="space-y-6">
                                @foreach($complaint->jobOrders as $job)
                                    @if($job->completionReport)
                                        <div class="border border-blue-100 rounded-lg p-5 bg-white shadow-sm">
                                            <h5 class="text-sm font-bold text-gray-700 mb-4 border-b border-blue-50 pb-2">Report for Job #{{ $job->id}}</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Submitted By (Supervisor)</span>
                                                    <span class="block text-gray-800 font-medium"><i class="fa-solid fa-user-tie text-blue-500 mr-1"></i> {{ $job->completionReport->reportedBy?->user?->name ?? 'System' }}</span>
                                                </div>
                                                <div>
                                                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Report Submitted At</span>
                                                    <span class="block text-gray-800 font-medium">{{ $job->completionReport->created_at->format('F j, Y \a\t g:i A') }}</span>
                                                </div>
                                                <div class="md:col-span-2 mt-2">
                                                    @forelse ($job->workers as $worker)
                                                        <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-md text-xs font-bold border border-blue-200">
                                                            <i class="fa-solid fa-wrench mr-1"></i> {{ $worker->user->name }}
                                                        </span>
                                                    @empty
                                                    <span class ="text-sm text-gray-500 italic">No workers logged for execution.</span>
                                                    @endforelse
                                                    </div>
                                                </div>
                                                @if ($job->completionReport->supervisor_comments)
                                                <div class="md:col-span-2 mt-2 bg-blue-50 p-3 rounded-lg border border-blue-100">
                                                    <span class="block text-xs font-bold text-blue-400 uppercase tracking-wider mb-1">Supervisor Comments</span>
                                                    <p class="text-sm text-gray-700 italic">{{ $job->completionReport->supervisor_comments }}</p>
                                                </div>
                                                @endif
                                            </div>
                            </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic text-sm"> No completion reports have been filed for this complaint yet. </p>
                        @endif
                    </div>
                </div>
                <div class="pl-2 pr-2 pt-4"></div>
                <div class="border border-gray-200 rounded-xl bg-white overflow-hidden shadow-sm">
                    <button @click="activeStage = activeStage === 5 ? null : 5" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition text-left">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full {{ $complaint->resolved_at ? 'bg-green-100 text-green-600 border-green-200' : 'bg-gray-100 text-gray-600 border-gray-200' }} flex items-center justify-center font-bold border">
                                5
                            </div>
                            <h4 class="font-bold text-gray-800">Resolution & Feedback</h4>
                        </div>
                        <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-200" :class="activeStage === 5 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="activeStage === 5" x-transition class="p-6 border-t border-gray-200 bg-gray-50/50">
                        @if($complaint->resolved_at)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Resolved By</span>
                                    <span class="block text-green-600 font-bold"><i class="fa-solid fa-check-double mr-1"></i> {{ $complaint->resolvedBy?->user?->name ?? 'System' }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Resolved Date</span>
                                    <span class="block text-gray-800 font-medium">{{ \Carbon\Carbon::parse($complaint->resolved_at)->format('F j, Y \a\t g:i A') }}</span>
                                </div>
                                <div class="md:col-span-2 mt-4 pt-4 border-t border-gray-200">
                                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Citizen Feedback</span>
                                    @if($complaint->feedback)
                                    <div class="bg-white p-4 rounded-lg border border-yellow-200 shadow-sm inline-block min-w-full md:w-2/3 lg:w-1/2">
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="flex text-yellow-400 text-lg">
                                                @for($i=1; $i <= 5; $i++)
                                                    <i class="fa-{{ $i <= $complaint->feedback->rating ? 'solid' : 'regular' }} fa-star"></i>
                                                @endfor
                                            </div>
                                            <span class="text-sm text-gray-800">{{ $complaint->feedback->rating }} / 5</span>
                                        </div>
                                        <p class="text-sm text-gray-600 italic">{{ $complaint->feedback->quality_comments ?? 'No comment provided.' }}</p>
                                    </div>
                                    @else
                                    <p class="text-gray-500 italic text-sm"> No feedback has been submitted by the citizen for this complaint yet. </p>
                                    @endif
                                </div>
                            </div>
                            @else
                            <p class="text-gray-500 italic text-sm"> This complaint has not been resolved yet. </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <script>
        function initReadonlyMap(){
            const location = {
                lat: {{ $complaint->latitude }},
                lng: {{ $complaint->longitude }}
            };

            const map = new google.maps.Map(document.getElementById("readonly-map"),{
                zoom:16,
                center:location,
                streetViewControl:false,
                mapTypeControl:false,
                gestureHandling:"none",
                zoomControl:false
            });

            new google.maps.Marker({
                position: location,
                map: map,
                animation: google.maps.Animation.DROP,
            });
        }
    </script>
</x-layout>
