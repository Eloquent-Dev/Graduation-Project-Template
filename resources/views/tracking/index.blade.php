<x-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 w-full">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">
                <i class="fa-solid fa-map-location-dot text-brand-orange mr-2"></i> Live Tracking
            </h2>
            <div class="flex gap-4 text-sm font-medium">
                <span class="flex items-center gap-1"><span class="w-3 h-3 bg-blue-500 rounded-full"></span> On Route</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 bg-yellow-500 rounded-full"></span> On Site</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 bg-green-500 rounded-full"></span> Available</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 bg-red-500 rounded-full"></span> Offline</span>
            </div>
        </div>
        <div class="bg-white p-2 rounded-2xl shadow-xl">
            <div id="tracking-map" class="w-full h-[600px] rounded-xl border-2 border-gray-100"></div>
        </div>
    </div>
    {{-- google maps Api using you code --}}
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps_key') }}&callback=initLiveTrackingMap&loading=async" async defer></script>

    <script>
        let map;
        let workerMarkers = {};
        let infoWindows = {};

        function initLiveTrackingMap(){
            const initialLocation = {lat:31.9539 , lng:35.9106};

            map = new google.maps.Map(document.getElementById("tracking-map"),{
                zoom: 12,
                center :initialLocation,
                mapTypeControl: true,
                streetViewControl: false,
            });

            fetchLocations();
            setInterval(fetchLocations, 5000);
        }
        function grtStatusColor(status){
            switch(status){
                case 'on_route': return '#3B82F6';
                case 'on_site': return '#EAB308';
                case 'available': return '#22C55E';
                case 'off-duty': return '#9CA3AF';
                default:        return '#F97316'
            }
        }
        function formatStatus(status){
            if(!status) return 'Unknown';
            return status.replace('_',' ').replace(/\b\w\g, l=> l.toUpperCase());
        }
        function fetchLocations(){
            fetch('api/worker-locations')
            .then(Response =>Response.json())
            .then(workers => {
                const position ={lat: parseFloat(worker.latitude), lng: parseFloat(worker.longitude)};
                const workerId = worker.id;
                const statusColor = getStatusColor(worker.tracking_status);
                const statusText = formatStatus(worker.tracking_status);

                const contentString =`
                <div class="p-2 min-w-[150px]">
                    <h3 class="font-bold text-gray-900">${worker.user.name}</h3>
                    <p class="text-xs text-gray-500 mb-2">${worker.job_title || 'Field Worker'}></p>
                    <span class="px-2 py-1 text-xs font-bold text-white rounded-full" style="background-color: ${statusColor}">
                        ${statusText}
                        </span>
                        </div>
                        `;
                        if (workerMarkers[workerId]){
                            workerMarkers[workerId].setPosition(position);
                            infoWindows[workerId].setContent(contentString);
                            workerMarkers[workerId].setIcon({
                                path: google.map.SymolPath.CIRCLE,
                                scale: 8,
                                fliiColor: statusColor,
                                fillOpacity: 1,
                                strokeColor:'#ffffff',
                                strockWeigt: 2,
                            });
                        }
                        else{
                            const marker = new google.maps.Markers({
                                position: position,
                                map: map,
                                title: worker.user.name,
                                icon:{
                                path: google.map.SymolPath.CIRCLE,
                                scale: 8,
                                fliiColor: statusColor,
                                fillOpacity: 1,
                                strokeColor:'#ffffff',
                                strockWeigt: 2,
                                }
                            });
                            const infoWindow = new google.maps.InfowWindow({
                                content: contentString
                            });
                            marker.addListener("click",()=>{
                                Object.values(infoWindows).forEach(iw => iw.close());
                                infoWindow.open(map, marker);
                            });
                            workerMarkers[workerId]= marker;
                            infoWindows[workerId]= infoWindow;
                        }
                        });
                    })
                    .catch(error => console.error('Error fetching live locations:',error));
                }
    </script>
    </x-layout>
