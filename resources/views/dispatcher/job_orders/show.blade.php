<x-layout>
    @section('title', 'Dispatch Job Order #JO-'.$jobOrder->id)
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
        <a href="{{ route('dispatcher.job_orders.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-blue font-medium text-sm mb-6 transition">
            <i class="fa-solid fa-arrow-left"></i> Back to Job Orders Queue
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-2xl font-bold text-brand-dark mb-1">Work Order #JO-{{ $jobOrder->id }}</h2>
                                <p class="text-xs text-gray-500">Linked to Complaint #{{ $jobOrder->complaint->id }} • Priority: <span class="font-bold text-gray-800 uppercase">{{ $jobOrder->priority }}</span></p>
                            </div>
                            <span class="bg-white text-gray-600 px-3 py-1 rounded text-xs font-bold border border-gray-200 shadow-sm">
                                <i class="fa-solid fa-tag text-brand-orange mr-1"></i> {{ $jobOrder->complaint->category->name }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Original Complaint Details</h4>
                        <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100 shadow-sm mb-6">
                            <p class="font-bold text-gray-800 mb-2">{{ $jobOrder->complaint->title }}</p>
                            <p class="text-gray-700 text-sm italic border-l-4 border-brand-blue pl-3 py-1">
                                "{{ $jobOrder->complaint->description }}"
                            </p>
                        </div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Target Location</h4>
                        <div id="readonly-map" class="w-full h-80 rounded-t-xl border-2 border-b-0 border-gray-200 shadow-inner"></div>
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $jobOrder->complaint->latitude }},{{ $jobOrder->complaint->longitude }}"
                            target="_blank"
                            class="w-full bg-gray-50 hover:bg-gray-100 text-brand-blue font-bold py-3 px-4 rounded-b-xl transition flex items-center justify-center gap-2 text-sm border-2 border-gray-200 pointer shadow-sm">
                            <i class="fa-solid fa-route text-brand-orange"></i> Get Directions to Site
                        </a>
                    </div>
                </div>
            </div>
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-t-brand-orange">
                    <h3 class="text-sm font-bold text-brand-dark mb-4"><i class="fa-solid fa-users-gear mr-2 text-brand-orange"></i> Assign Field Team</h3>

                    <form action="{{ route('dispatcher.job_orders.update',$jobOrder->id) }}" method="post" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2 border-b pb-1">Assign Supervisor(s)</label>
                            <div class="max-h-60 overflow-y-auto space-y-2 pr-2">
                                @forelse ($supervisors as $supervisor)
                                    <label class="flex items-center p-3 border border-gray-200 rounded-lg pointer hover:bg-blue-50 transition group">
                                        <input type="checkbox" name="supervisor_ids[]" value="{{ $supervisor->id }}"
                                        class="w-4 h-4 text-brand-blue border-gray-300 rounded focus:ring-brand-blue"
                                        {{ $jobOrder->workers->contains($supervisor->id) ? 'checked' : '' }}>
                                        <div class="ml-3 flex flex-col">
                                            <span class="text-sm font-bold text-gray-800 group-hover:text-brand-blue">{{ $supervisor->user->name }}</span>
                                            <span class="text-[10px] text-gray-500 uppercase">{{ $supervisor->job_title }}</span>
                                        </div>
                                    </label>
                                @empty
                                    <div class="p-4 bg-red-50 text-red-600 text-xs rounded-lg border border-red-100 text-center">
                                        <i class="fa-solid fa-trangle-exclamation mr-1"></i> No supervisors available in this division.
                                    </div>
                                @endforelse
                            </div>
                            @error('supervisor_ids') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2 border-b pb-1">Assign worker(s)</label>

                            <div class="max-h-48 overflow-y-auto space-y-2 pr-2">
                                @forelse ($workers as $worker)
                                    <label class="flex items-center p-3 border border-gray-200 rounded-lg pointer hover:bg-gray-50 transition group">
                                        <input type="checkbox" name="worker_ids[]" value="{{ $worker->id }}"
                                        class="w-4 h-4 text-brand-orange border-gray-300 rounded focus:ring-brand-orange"
                                        {{ $jobOrder->workers->contains($worker->id) ? 'checked' : '' }}>

                                        <div class="ml-3 flex flex-col">
                                            <span class="text-sm font-bold text-gray-800">{{ $worker->user->name }}</span>
                                            <span class="text-[10px] text-gray-500 uppercase">{{ $worker->job_title }}</span>
                                        </div>
                                    </label>
                                @empty
                                    <div class="p-3 bg-red-50 text-red-600 text-xs rounded-lg border border-red-100 text-center">
                                        <i class="fa-solid fa-trangle-exclamation mr-1"></i> No workers available in this division.
                                    </div>
                                @endforelse
                            </div>
                            @error('worker_ids') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full bg-brand-orange hover:bg-orange-600 text-white font-bold py-3 rounded-lg transition text-sm shadow flex items-center justify-center gap-2 pointer">
                            <i class="fa-solid fa-satellite-dish"></i> Dispatch Team
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps_key') }}&callback=initReadonlyMap&loading=async" async defer></script>
    <script>
        function initReadonlyMap(){
            const location = {
                lat: {{ $jobOrder->complaint->latitude }},
                lng: {{ $jobOrder->complaint->longitude }}
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
