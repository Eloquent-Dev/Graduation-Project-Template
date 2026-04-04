<x-layout>
    @section('title', 'Complaint Details')

    <div class="max-w-5xl mx-auto px-6 lg:px-8 py-8 w-full">
        <a href="{{ route('complaints.index') }}" class="inline-flex items-center gap-2 text-gray-500 hove:text-brand-blue font-medium text-sm mb-6 transition">
            <i class="fa-solid fa-arrow-left"></i> Back to My Complaints
        </a>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-brand-dark">{{ $complaint->title }}</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Reported on {{ $complaint->created_at->format('F j, Y \a\t g:i A') }}
                    </p>
                </div>
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
                <span class="px-4 py-2 rounded-full text-sm font-bold border shadow-sm {{ $colorClass }}">
                    Status: {{ str_replace('_',' ', strtoupper($complaint->status)) }}
                </span>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6 flex flex-col">
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Category</h4>
                        <p class="text-gray-800 font-medium bg-gray-50 inline-block px-4 py-2 rounded-lg border border-gray-200 shadow-sm">
                           <i class="fa-solid fa-tag"></i> {{ $complaint->category->name }}
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
                    <div id="readonly-map" class="w-full h-64 rounded-lg border-2 border-gray-200 shadow-inner"></div>

                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $complaint->latitude }},{{ $complaint->longitude }}"
                        target="_blank"
                        class="w-full bg-gray-50 hover:bg-gray-100 text-brand-blue font-bold py-3 px-4 rounded-b-xl transition flex items-center justify-center gap-2 text-sm border-2 border-gray-200 pointer shadow-sm group">
                        <i class="fa-solid fa-route text-brand-orange group-hover:scale-110 transition-transform"></i>
                        Open in Google Maps
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Forced Feedback Form --}}
    @if ($complaint->status=== 'approved' && !$complaint->feedback())
    <div id="feedback-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/80 bg-opacity-75 backdrop-blur-sm px-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 transform transition-all border border-gray-100">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 text-green-600 rounded-full mb-4">
                     <i class="fa-solid fa-thumbs-up text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Resolution Feedback!</h3>
                <p class="text-gray-500 mt-2">Please rate our service to continue</p>
            </div>
            <form action="{{ route('complaints.feedback', $complaint) }}" method="POST" id="feedback-form " class="space-y-6">
                @csrf
                {{-- Star rating for quality --}}
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-400 mb-2">Overall Quality:</label>
                    <div class="flex flex-row-reverse items-center gap-2 text-3xl">
                        @for ($i = 5; $i >= 0; $i-=0.5)
                            <input type="radio" id="q-{{ $i }}" name="rating" value="{{ $i }}" class="hidden peer" required>
                            <label for="q-{{ $i }}" class="cursor-pointer text-gray-300 peer-hover:text-yellow-400 peer-checked:text-yellow-400 transition-color">
                                <i class="fa-solid fa-star"></i>
                            </label>
                        @endfor
                    </div>
                </div>
                {{--star rating for speed--}}
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-400 uppercase tracking-wider mb-3 text-center">Resolution speed:</label>
                    <div class="flex flex-row-reverse items-center gap-2 text-2xl text-gray-300">
                        @for ($i = 5; $i >= 0; $i-=0.5)
                            <input type="radio" id="s-{{ $i }}" name="speed_rating" value="{{ $i }}" class="hidden peer" required>
                            <label for="s-{{ $i }}" class="cursor-pointer text-gray-300 peer-hover:text-brand-orange peer-checked:text-brand-orange transition-color">
                                <i class="fa-solid fa-star"></i>
                            </label>
                        @endfor
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-400 mb-2">Comments:</label>
                    <textarea name="quality_comments" rows="3" class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-brand-blue focus:border-brand-blue" placeholder="Tell us more..."></textarea>
                </div>
                <button type="submit" class="w-full bg-brand-blue hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg active:scale-95">
                    Submit Feedback
                </button>
            </form>
        </div>
    </div>
    @endif

    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps_key') }}&callback=initReadonlyMap&loading=async" async defer></script>
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

        document.addEventListener('DOMContentLoaded', function(){
            const modal = document.getElementById('feedback-modal');
            if(modal){
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                window.addEventListener('keydown', function(e){
                    if(e.key === 'Escape'){
                        e.preventDefault();
                        return false;
                    }
                });
            }
        });
    </script>


</x-layout>
