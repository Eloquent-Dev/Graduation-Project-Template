<x-layout>
    @section('title','Review #JO-'.$jobOrder->id)

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <a class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-blue font-medium text-sm mb-6 transition" href="{{ route('admin.reviews.index') }}">
            <i class="fa-solid fa-arrow-left"></i> Back to Pending Reviews
        </a>

        <div class="bg-white p-5 rounded-xl shadow-sm border boder-gray-200 mb-6 flex flex-col sm:flex-row justifiy-between items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900">QA Review: Job Order #JO-{{ $jobOrder->id }}</h2>
                <p class="text-sm text-gray-500">Review the evidence before officially closing this ticket.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                <div class="bg-gray-200/50 p-4 border-b border-gray-200 flex items-center gap-2">
                    <i class="fa-solid fa-bullhorn text-gray-500"></i>
                    <h3 class="font-bold text-gray-800">1. Original Citizen Report</h3>
                </div>

                <div class="p-5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-brand-blue bg-blue-50 px-2 py-1 rounded">
                        {{ $jobOrder->complaint->category->name }}
                    </span>
                    <h4 class="text-lg font-bold text-gray-900 mt-3 mb-2">{{ $jobOrder->complaint->title }}</h4>
                    <p class="text-sm text-gray-600 italic border-l-4 border-gray-300 pl-3 py-1 mb-5">{{ $jobOrder->complaint->description }}</p>

                    @if($jobOrder->complaint->image_path)
                        <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Citizen Photo</h5>
                        <img src="{{ asset('storage/'.$jobOrder->complaint->image_path) }}" class="w-full rounded-lg border border-gray-200 shadow-sm max-h-64 object-cover">
                    @else
                        <div class="bg-gray-100 border border-gray-200 border-dashed rounded-lg p-6 text-center text-gray-400 text-sm">
                            <i class="fa-solid fa-camera-slash text-2xl mb-2"></i>
                            <p>No initial photo provided by the citizen.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl border border-blue-200 overflow-hidden shadow-sm">
                <div class="bg-blue-50 p-4 border-b border-blue-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-check text-brand-blue"></i>
                        <h3 class="font-bold text-brand-blue">2. Supervisor Completion Report</h3>
                    </div>
                    <span class="text-xs font-bold text-gray-500">
                        {{ $jobOrder->completionReport?->completed_at->diffForHumans() ?? 'Unknown time' }}
                    </span>
                </div>

                <div class="p-5">
                    <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Resolution Notes</h5>
                    <div class="bg-blue-50/50 text-gray-800 text-sm p-4 rounded-lg border border-blue-100 mb-5 leading-relaxed">
                        {{ $jobOrder->completionReport?->supervisor_comments }}
                    </div>

                    <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Official Evidence</h5>
                    @if($jobOrder->completionReport?->image_path)
                    <img src="{{ asset('storage/'.$jobOrder->completionReport->image_path) }}" class="w-full rounded-lg border border-gray-200 shadow-sm max-h-80 object-cover">
                    @else
                        <div class="bg-blue-50/30 border border-blue-100 border-dashed rounded-lg p-6 text-center text-blue-300 text-sm">
                            <i class="fa-solid fa-camera-slash text-2xl mb-2"></i>
                            <p>No completion photo attached.</p>
                        </div>
                    @endif
                    <div class="mt-4 flex items-center gap-2 text-xs text-green-700 bg-green-50 p-3 rounded border border-green-100">
                        <i class="fa-solid fa-signature"></i>
                        <span class="font-bold">Accountability Statement Signed & Verified by Supervisor</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-8 bg-white border-2 border-brand-dark rounded-xl shadow-lg overflow-hidden">
                <div class="bg-brand-dark px-6 py-4 text-white flex items-center gap-3">
                    <i class="fa-solid fa-gavel text-xl"></i>
                    <h3 class="text-lg font-bold">3. Official Administrative Decision</h3>
                </div>

                <form action="{{ route('admin.reviews.process',$jobOrder->id) }}" method="post" class="p-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <label class="relative flex flex-col p-4 pointer border-2 border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-500 transition-all duration-200 focus-within:border-green-500 focus-within:ring-1 focus-within:ring-green-500 group">
                            <input type="radio" name="decision" value="approve" class="h-0 w-0 opacity-0 peer" required>
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fa-solid fa-circle-check text-gray-400 group-hover:text-green-500 peer-checked:text-green-600 text-xl transition-colors"></i>
                                <span class="font-bold text-gray-900 peer-checked:text-green-800">Approve Work</span>
                            </div>
                            <span class="text-xs text-gray-500 leading-relaxed pl-8">Mark "Approved" pending citizen feedback.</span>
                            <div class="absolute inset-0 border-2 border-transparent peer-checked:border-green-500 rounded-lg pointer-events-none"></div>
                        </label>

                        <label class="relative flex flex-col p-4 pointer border-2 border-gray-200 rounded-lg hover:bg-orange-50 hover:border-brand-orange transition-all duration-200 focus-within:border-brand-orange focus-within:ring-2 focus-within:ring-brand-orange group">
                            <input type="radio" name="decision" value="reject_to_crew" class="h-0 w-0 opacity-0 peer">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fa-solid fa-rotate-left text-gray-400 group-hover:text-brand-orange peer-checked:text-brand-orange transition-colors text-xl"></i>
                                <span class="font-bold text-gray-900 peer-checked:text-brand-orange">Reject to Workers Team</span>
                            </div>
                            <span class="text-xs text-gray-500">Send back to "In Progress".</span>
                            <div class="absolute inset-0 border-2 border-transparent peer-checked:border-brand-orange rounded-lg pointer-events-none"></div>
                        </label>

                        <label class="relative flex flex-col p-4 pointer border-2 border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-500 transition-all duration-200 focus-within:border-red-500 focus-withing:ring-1 focus-within:ring-red-500 group">
                            <input type="radio" name="decision" value="reject_to_dispatcher" class="h-0 w-0 opacity-0 peer">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fa-solid fa-headset text-gray-400 group-hover:text-red-500 peer-checked:text-red-500 text-lg"></i>
                                <span class="font-bold text-gray-900 peer-checked:text-red-500">Reject to Dispatchers</span>
                            </div>
                            <span class="text-xs text-gray-500">Remove crew, reset to "Pending".</span>
                            <div class="absolute inset-0 border-2 border-transparent peer-checked:border-red-500 rounded-lg pointer-events-none"></div>
                        </label>

                        <label class="relative flex flex-col p-4 pointer border-2 border-gray-200 rounded-lg hover:bg-gray-100 hover:border-gray-600 transition-all duration-200 focus-within:border-gray-600 focus-withing:ring-1 focus-within:ring-gray-600 group">
                            <input type="radio" name="decision" value="reject_complaint" class="h-0 w-0 opacity-0 peer">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fa-solid fa-ban text-gray-400 group-hover:text-gray-600 peer-checked:text-gray-600 text-lg"></i>
                                <span class="font-bold text-gray-900 peer-checked:text-gray-600">Reject Complaint</span>
                            </div>
                            <span class="text-xs text-gray-500">Mark "Rejected" (scam/invalid).</span>
                            <div class="absolute inset-0 border-2 border-transparent peer-checked:border-gray-600 rounded-lg pointer-events-none"></div>
                        </label>
                    </div>

                    <div class="mb-6">
                        <label for="admin_notes" class="block text-sm font-bold text-gray-700 mb-2">
                            Admin Notes / Closure Reason
                            <span class="text-red-500 font-normal text-xs bg-red-50 px-2 py-0.5 rounded ml-1">(Required if rejecting)</span>
                        </label>
                        <textarea
                        name="admin_notes"
                        id="admin_notes"
                        rows="5"
                        placeholder="Please provide a detailed explaination if you are rejecting this complaint..."
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-dark focus:ring-2 focus:ring-brand-dark/20 text-sm transition p-4"
                        >{{ old('admin_notes') }}</textarea>

                    @error('admin_notes')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                    </div>

                    <div class="flex justify-end border-t border-gray-100 pt-5">
                        <button type="submit" class="px-8 py-3 pointer bg-brand-dark hover:bg-gray-900 text-white font-bold rounded-lg shadow-sm transition flex items-center gap-2 text-lg">
                            Execute Decision <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
    </div>
</x-layout>
