<x-layout>
    @section('title', $user->name)

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        <div class="mb-8">
            <a href="{{ route('admin.users.complaints.show', session('complaint_id')) }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-blue font-medium text-sm mb-4 transition">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Previous Complaint
            </a>
            <h1 class="text-3xl font-bold text-gray-900">User Profile</h1>
            <p class="text-sm mt-1 text-gray-500">Viewing official system record and details</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col items-center text-center">
                    <div class="w-32 h-32 rounded-full bg-brand-blue flex items-center justify-center text-white text-4xl font-bold mb-4 shadow-inner">
                        {{ substr($user->name, 0,1) }}
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500 mb-4">System Role: <span class="text-brand-blue font-bold">{{ ucfirst($user->role) }}</span></p>

                    @if($user->employee)
                        <div class="z-10 mt-2">
                            @if ($user->employee->duty_status === 'on_duty')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-700 border border-green-200">
                                    On Duty
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-700 border border-red-200">
                                    Off Duty
                                </span>
                            @endif
                        </div>
                    @endif

                    <div class="w-full mt-6 pt-6  border-t border-gray-100">
                        <p class="text-xs text-gray-400">Member Since {{ $user->created_at->format('F Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 space-y-6">
                @if ($user->employee)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <i class="fa-solid fa-briefcase text-brand-blue"></i> Employee Details
                            </h3>
                        </div>

                        <div class="p-6">
                            @if ($user->employee->pending_job_title)
                                <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-start gap-3 shadow-sm">
                                    <div class="mt-0.5 text-yellow-600">
                                        <i class="fa-solid fa-circle-exclamation text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-yellow-800">Pending Title Change Request</h4>
                                        <p class="text-xs text-yellow-700  mt-1">
                                            This user has requested to change their job title to <span class="font-bold bg-yellow-200/50 px-1.5 py-0.5 rounded">{{ $user->employee->pending_job_title }}</span>
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Job Title</dt>
                                    <dd class="inline-block text-gray-700 px-3 py-1.5 border border-gray-200 bg-gray-100 rounded-lg font-medium">
                                        {{ $user->employee->job_title ?? 'N/A' }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Division</dt>
                                    <dd class="mt-2 text-gray-900 text-sm">
                                        @if ($user->employee->division)
                                            <span class="inline-block  bg-gray-100 text-gray-700 px-2 py-1 rounded-lg border border-gray-200 font-medium">
                                                {{ $user->employee->division->name }}
                                            </span>
                                        @else
                                            <span class="italic text-gray-400">-- unassigned --</span>
                                        @endif
                                    </dd>

                                </div>

                                <div class="sm:col-span-2 mt-2">
                                    <dt class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">System ID</dt>
                                    <dd class="mt-1 text-brand-blue font-bold font-mono bg-blue-50 px-3 py-1.5 inline-block rounded-lg border border-blue-100">
                                        EMP-{{ str_pad($user->employee->id, 5, '0', STR_PAD_LEFT) }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                @endif

                <div class="bg-white shado-sm rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-address-card text-gray-800"></i> Personal Information
                        </h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6">
                            <div>
                                <dt class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Full Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Email Address</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Phone Number</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->phone }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">National ID</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->national_no }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
