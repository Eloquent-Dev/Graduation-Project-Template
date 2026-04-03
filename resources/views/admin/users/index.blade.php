<x-layout>
    @section('title', 'User Management')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Master User Directory</h1>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                    <div class="bg-blue-100 text-brand-blue p-3 rounded-lg"><i class="fa-solid fa-users text-xl"></i></div>
                    <div><p class="text-xs text-gray-500 font-bold uppercase">Total Users</p><p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p></div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                    <div class="bg-purple-100 text-purple-600 p-3 rounded-lg"><i class="fa-solid fa-shield-halved text-xl"></i></div>
                    <div><p class="text-xs text-gray-500 font-bold uppercase">Administrators</p><p class="text-2xl font-bold text-gray-900">{{ $stats['admins'] }}</p></div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                    <div class="bg-indigo-100 text-indigo-600 p-3 rounded-lg"><i class="fa-solid fa-headset text-xl"></i></div>
                    <div><p class="text-xs text-gray-500 font-bold uppercase">Dispatchers</p><p class="text-2xl font-bold text-gray-900">{{ $stats['dispatchers'] }}</p></div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                    <div class="bg-orange-100 text-brand-orange p-3 rounded-lg"><i class="fa-solid fa-clipboard-user text-xl"></i></div>
                    <div><p class="text-xs text-gray-500 font-bold uppercase">Field Supervisors</p><p class="text-2xl font-bold text-gray-900">{{ $stats['supervisors'] }}</p></div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                    <div class="bg-amber-100 text-amber-600 p-3 rounded-lg"><i class="fa-solid fa-hard-hat text-xl"></i></div>
                    <div><p class="text-xs text-gray-500 font-bold uppercase">Field workers</p><p class="text-2xl font-bold text-gray-900">{{ $stats['workers'] }}</p></div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                    <div class="bg-green-100 text-green-600 p-3 rounded-lg"><i class="fa-solid fa-house-chimney-user text-xl"></i></div>
                    <div><p class="text-xs text-gray-500 font-bold uppercase">Citizens</p><p class="text-2xl font-bold text-gray-900">{{ $stats['citizens'] }}</p></div>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6">
            <form action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="grow">
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or National ID..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue outline-none text-sm">
                    </div>
                </div>

                <div class="w-full md:w-64">
                    <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue outline-none text-sm" onchange="this.form.submit()">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') === 'admin'? 'selected' : '' }}>Administrator</option>
                        <option value="dispatcher" {{ request('role') === 'dispatcher' ? 'selected' : ''}}>Dispatcher</option>
                        <option value="supervisor" {{ request('role') === 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                        <option value="worker" {{ request('role') === 'worker' ? 'selected': '' }}>Worker</option>
                        <option value="citizen" {{ request('role') === 'citizen' ? 'selected':'' }}>Citizen</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-brand-blue hover:bg-blue-800 text-white px-6 py-2 rounded-lg text-sm font-bold transition shadow-sm pointer">Search</button>
                    @if(request()->hasAny(['search','role']))
                        <a href="{{ route('admin.users.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-bold transition border border-gray-300">Clear</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th class="p-4 font-bold">User Identity</th>
                            <th class="p-4 font-bold">Contact & ID</th>
                            <th class="p-4 font-bold">System Role</th>
                            <th class="p-4 font-bold">Divison / Team</th>
                            <th class="p-4 font-bold">Complaints</th>
                            <th class="p-4 font-bold text-right">Danger Zone</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-brand-dark flex items-center justify-center text-white font-bold shadow-inner">
                                            {{ strtoupper(substr($user->name,0,1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">Joined {{ $user->created_at->format('M Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="text-sm text-gray-800"><i class="fa-regular fa-envelope text-gray-400 mr-1"></i>{{ $user->email }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <i class="fa-regular fa-id-card text-gray-400 mr-1"></i>
                                        {{ $user->national_no }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <form action="{{ route('admin.users.update_role',$user->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="text-sm border-gray-300 rounded-md focus:ring-brand-blue focus:border-brand-blue py-1.5 pl-3 pr-8 shadow-sm
                                        {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700 font-bold border-purple-200' : '' }}
                                        {{ $user->role === 'dispatcher' ? 'bg-blue-50 text-blue-700 font-bold border-blue-200' : '' }}
                                        {{ $user->role === 'supervisor' ? 'bg-orange-50 text-orange-700 font-bold border-orange-200' : '' }}
                                        {{ $user->role === 'worker' ? 'bg-green-50 text-green-700 font-bold border-green-200' : '' }}
                                        {{ $user->role === 'citizen' ? 'bg-gray-50 text-gray-700 font-bold border-gray-200' : '' }}
                                         "{{ $user->id === auth()->id() ? 'disabled': '' }}>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected':'' }}>Administrator</option>
                                            <option value="dispatcher" {{ $user->role === 'dispatcher' ? 'selected' : '' }}>Dispatcher</option>
                                            <option value="supervisor" {{ $user->role === 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                            <option value="worker" {{ $user->role === 'worker' ? 'selected' : '' }}>Worker</option>
                                            <option value="citizen" {{ $user->role === 'citizen' ? 'selected' : '' }}>Citizen</option>
                                        </select>

                                        @if ($user->id !== auth()->id())
                                            <button type="submit" class="text-xs bg-gray-100 hover:bg-brand-blue hover:text-white text-gray-600 px-2 py-1.5 rounded transition pointer" title="Save Role">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        @else
                                            <span class="text-[10px] text-purple-500 font-bold uppercase tracking-wider ml-2">You</span>
                                        @endif
                                    </form>
                                </td>
                                <td class="p-4">
                                    @if(in_array($user->role,['dispatcher','worker','supervisor','admin']))
                                        <form action="{{ route('admin.users.update_division',$user->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')

                                            <select name="division_id" class="text-sm border-gray-300 rounded-md focus:ring-brand-blue focus:border-brand-blue py-1.5 pl-3 pr-8 shadow-sm bg-blue-50/50">
                                                <option value="">-- Unassigned --</option>
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->id }}" {{ $user->employee->division_id == $division->id ? 'selected':'' }}>{{ $division->name }}</option>
                                                @endforeach
                                            </select>

                                            <button type="submit" class="text-xs bg-gray-100 hover:bg-brand-blue hover:text-white text-gray-600 px-2 py-1.5 rounded transition pointer" title="Save Division">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                    @else
                                        <div class="flex items-center gap-2 text-gray-400 opacity-70">
                                            <i class="fa-solid fa-minus text-xs"></i>
                                            <span class="text-xs font-medium italic">Not Applicable</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <a href="{{ route('admin.users.complaints.index', $user->id) }}" class="inline-block items-center gap-1.5 bg-blue-50 hover:bg-blue-100 text-brand-blue border border-blue-200 px-2 py-1.5 rounded-lg text-xs font-bold transition shadow-sm">
                                        View Complaints
                                    </a>
                                </td>
                                <td class="p-4 text-right">
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('WARNING: Are you sure you want to permanently delete {{ $user->name }}? This action isn\'t reversable.');">
                                            @csrf
                                            @method('DELETE')
                                            @if($user->role !== 'admin')
                                            <button class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition border border-red-100 hover:border-red-500 pointer" title="Delete User">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                            @endif
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-500">
                                    <i class="fa-solid fa-users-slash text-4xl mb-3 text-gray-300"></i>
                                    <p class="text-lg font-bold">No users found.</p>
                                    <p class="text-sm">Try adjusting your search or filter criteria.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layout>
