<x-layout>
    @section('title', 'My Assignments')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">


        <div class="flex justify-between items-end border-b border-gray-200 pb-5 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-brand-dark">My Assignments</h2>
                <p class="text-gray-500 text-sm mt-1">Your active field tasks for today.</p>
            </div>
            <div class="bg-blue-50 text-brand-blue px-4 py-2 rounded-lg font-bold text-sm shadow-sm">
                <i class="fa-solid fa-helmet-safety mr-2"></i> Active: {{ $assignments->total() }}
            </div>
        </div>

        @if($assignments->isEmpty())
            <div class="bg-gray-50/50 border-2 border-dashed border-gray-200 rounded-2xl p-12 text-center flex flex-col items-center justify-center min-h-100 transition-all hover:bg-gray-50 hover:border-gray-300 shadow-sm mt-10">
                <div class="w-24 h-24 bg-green-50 text-green-500 rounded-full relative flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-mug-hot text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">No Active Assignments</h3>
                <p class="text-gray-500 text-sm">You have no pending tasks. Take a break or check back later.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($assignments as $assignment)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md duration-300 transition">
                            <div class="bg-gray-50 px-5 py-3 border-b border-gray-100 flex justify-between items-center">
                                <span class="font-bold text-sm text-gray-700">
                                    <i class="fa-solid fa-hashtag text-gray-400 mr-1"></i>JO-{{ $assignment->id }}
                                </span>

                                @php
                                    $priorityColors = [
                                        'high' => 'bg-red-100 text-red-800 border-red-200 animate-pulse',
                                        'medium' => 'bg-orange-100 text-orange-800 border-orange-200',
                                        'low' => 'bg-green-100 text-green-800 border-green-200'
                                    ];
                                    $pColor = $priorityColors[$assignment->priority] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $pColor }}">
                                    <i class="fa-solid fa-flag mr-1"></i> {{ $assignment->priority }}
                                </span>
                            </div>
                            <div class="p-5 flex-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-brand-blue mb-2 inline-block bg-blue-50 px-2 py-1 rounded">
                                    {{ $assignment->complaint->category->name }}
                                </span>

                                <h4 class="text-lg font-bold text-brand-dark leading-tight mb-2">
                                    {{ $assignment->complaint->title }}
                                </h4>
                                <p class="text-sm text-gray-500 line-clamp-2 mb-2">
                                    {{ $assignment->complaint->description }}
                                </p>

                                <div class="flex items-center text-xs text-gray-400 font-medium">
                                    <i class="fa-solid fa-clock mr-1.5"></i>
                                    Assigned {{ $assignment->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <div class="p-4 border-t border-gray-100 bg-white mt-auto">
                                <div class="grid grid-cols-2 gap-3">
                                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $assignment->complaint->latitude }},{{ $assignment->complaint->longitude }}" target="_blank" class="flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-lg transition">
                                    <i class="fa-solid fa-route"></i> Map
                                </a>

                                @if(!$isWorkerOnDuty)
                                <div class="w-full h-full flex item-center justify-center gap-2 px-2 py-2 bg-red-50 text-red-500 text-[10px] font-bold rounded-lg border border-red-100 text-center leading-tight">
                                    Clock In First
                                </div>
                                @else
                                    @php $myStatus = $assignment->pivot->worker_status @endphp

                                    @if ($myStatus === 'off_site')
                                    <form action="{{ route('worker.assignments.status',$assignment->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="worker_status" value="in_route">
                                        <button type="submit" class="w-full h-full cursor-pointer flex items-center justify-center gap-2 px-2 py-2 bg-brand-blue hover:bg-blue-800 text-white text-sm font-bold rounded-lg transition shadow-sm">
                                            <i class="fa-solid fa-truck"></i> Start Route
                                        </button>
                                    </form>
                                    @elseif($myStatus === 'in_route')
                                    <form action="{{ route('worker.assignments.status',$assignment->id) }}" method="post" class="h-full">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="worker_status" value="on_site">
                                        <button type="submit" class="w-full h-full cursor-pointer flex items-center justify-center gap-2 px-2 py-2 bg-brand-blue hover:bg-blue-800 text-white text-sm font-bold rounded-lg transition shadow-sm">
                                            <i class="fa-solid fa-location-dot"></i> Arrived
                                        </button>
                                    </form>
                                    @elseif($myStatus === 'on_site')
                                    <form action="{{ route('worker.assignments.status',$assignment->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="worker_status" value="off_site">
                                        <button type="submit" class="w-full h-full pointer flex items-center justify-center gap-2 px-2 py-2 bg-brand-blue hover:bg-blue-800 text-white text-sm font-bold rounded-lg transition shadow-sm">
                                            <i class="fa-solid fa-truck"></i> Off Site
                                        </button>
                                    </form>
                                    @endif
                                @endif
                            </div>
                            <a href="{{ route('worker.assignments.show',$assignment->id) }}" class="w-full block text-center text-xs font-bold text-gray-500 hover:text-brand-blue transition mt-2">
                                View Task Details & Crew <i class="fa-solid fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $assignments->links() }}
            </div>
        @endif
    </div>
</x-layout>
