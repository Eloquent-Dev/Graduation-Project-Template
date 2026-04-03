<x-layout>
    @section('title', 'Ticket #' . str_pad($complaint->id,5,'0', STR_PAD_LEFT) . ' - ' . $complaint->title)

    <div class="max-w-5xl mx-auto px-6 lg:px-8 py-8 w-full">
        <a href="{{ route('admin.users.complaints.index', $complaint->user_id) }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-blue font-medium text-sm mb-6 transition">
            <i class="fa-solid fa-arrow-left"></i> Back to Complaints
        </a>

        <div class="bg-linear-to-r from-brand-dark to-brand-blue rounded-xl shadow-lg border border-gray-800 overflow-hidden mb-6 flex flex-col sm:flex-row items-center justify-between p-6 gap-4">
            <div class="flex items-center gap-4 text-white w-full sm:w-auto">
                <div class="w-12 h-12 rounded-full bg-brand-orange flex items-center justify-center text-xl font-bold shadow-inner shrink-0">
                    {{ substr($complaint->user->name,0,1) }}
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-bold mb-0.5">Submitted By</p>
                    <h3 class="text-lg font-bold">{{ $complaint->user->name }} <span class="text-[10px] ml-2 px-2 py-0.5 bg-gray-700 rounded text-gray-300">{{ $complaint->user->role }}</span></h3>
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

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <div class="mb-2">
                        <span class="text-xs font-mono bg-gray-100 text-gray-600 px-2 py-1 rounded border border-gray-200">
                            Ticket #{{ str_pad($complaint->id,5,'0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold text-brand-dark">{{ $complaint->title }}</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Reported on {{ $complaint->created_at->format('F j, Y \a\t g:i A') }}
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
                <span class="px-4 py-2 rounded-full text-sm font-bold border shadow-sm {{ $ColorClass }}">
                    Status: {{ str_replace('_', ' ', strtoupper($complaint->status)) }}
                </span>
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
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initReadonlyMap&loading=async" async defer></script>
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
