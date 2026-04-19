<x-layout>
    @section('title','Submit a complaint')

    <div class="mr-auto ml-auto px-6 py-8 lg:px-8 w-[50%]">
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <h2 class="text-3xl font-bold text-brand-dark mb-6 border-b pb-4">Report an Issue</h2>

        <form action="{{ route('complaints.store') }}" method="post" class="space-y-6" enctype="multipart/form-data">
            @csrf

            @guest
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 space-y-4 mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-brand-dark">Guest Information</h3>
                        <p class="text-xs text-gray-500">Since You're not logged in, Please provide your details to submit this issue.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" value="{{ old('complainant_name') }}" placeholder="John Doe" name="complainant_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue outline-none">
                        @error('complainant_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email Address<span class="text-red-500">*</span></label>
                        <input type="email" value="{{ old('email') }}" placeholder="john.doe@example.com" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue outline-none">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">National Number</label>
                            <input type="text" value="{{ old('guest_national_no') }}" placeholder="For Citizens" name="guest_national_no" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue outline-none">
                            @error('guest_national_no') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Passport Number</label>
                            <input type="text" value="{{ old('passport_no') }}" placeholder="For Non-Citizens" name="passport_no" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue outline-none">
                            @error('passport_no') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-400 italic">* Please provide either a National Number OR Passport Number.</p>
                </div>
            @endguest

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Issue Title</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue outline-none">
                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Category</label>
                <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue outline-none">
                    <option value="" disabled selected>Select an Issue category...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Detailed Description</label>
                <textarea name="description" rows="4" placeholder="Please provide details about the issue..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue outline-none">{{ old('description') }}</textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Attach a Photo (Optional)</label>
                <p class="text-xs text-gray-500 mb-2">A clear photo helps our crews locate and fix the issue faster.</p>
                <input
                type="file"
                name="image"
                id="image"
                accept="image/*"
                class="w-full pointer block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-brand-blue hover:file:bg-blue-100 transition">
                @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-bold text-gray-700">Exact Location</label>
                    <button type="button" id="get-location-btn" class="text-xs bg-brand-orange hover:bg-orange-600 text-white px-3 py-1 rounded shadow transition flex items-center gap-1">
                        <i class="fa-solid fa-location-crosshairs"></i> Use My Location
                    </button>
                </div>

                <p class="text-xs text-gray-500 mb-2">Click on the map to drop a pin at the issue's location.</p>

                <div id="map" class="w-full h-80 rounded-lg border-2 border-gray-200 shadow-inner"></div>

                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

                @error('latitude') <span class="text-red-500 text-xs">Please drop a pin on the map.</span> @enderror
            </div>

            <div class="pt-4 border-t border-gray-100">
                <button type="submit" class="w-full bg-brand-blue hover:bg-blue-800 text-white font-bold py-3 rounded-lg shadow-lg transition text-lg pointer">
                    Submit Complaint
                </button>
            </div>
        </form>
    </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps_key') }}&callback=initMap&loading=async" async defer></script>
<script>
    let map;
    let marker;

    function initMap() {
        const defaultLocation = {lat: 31.9454, lng: 35.9284};

        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            center: defaultLocation,
            streetViewControl: false,
            mapTypeControl: false,
        });

        const oldLat = document.getElementById('latitude').value;
        const oldLng = document.getElementById('longitude').value;

        if (oldLat && oldLng) {
            placeMarker({lat: parseFloat(oldLat), lng: parseFloat(oldLng)});
            map.setCenter({lat: parseFloat(oldLat), lng: parseFloat(oldLng)});
        }

        map.addListener('click', (e) => {
            placeMarker(e.latLng);
        });
    }

    function placeMarker(latLng) {
        if (marker) {
            marker.setPosition(latLng);
        } else {
            marker = new google.maps.Marker({
                position: latLng,
                map: map,
                animation: google.maps.Animation.DROP,
            });
        }

        // FIX 3: Moved outside the else block so coordinates update every time it moves!
        // FIX 1: Fixed the "doument" typo
        document.getElementById("latitude").value = latLng.lat();
        document.getElementById("longitude").value = latLng.lng();
    }

    // FIX 2: Moved this entirely outside of the placeMarker function!
    document.getElementById('get-location-btn').addEventListener('click', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(pos);
                    map.setZoom(17);
                    placeMarker(new google.maps.LatLng(pos.lat, pos.lng));
                },
                () => {
                    alert("Error: The Geolocation service failed or you denied permission.");
                }
            );
        } else {
            alert("Error: Your browser doesn't support geolocation.");
        }
    });
</script>

</x-layout>
