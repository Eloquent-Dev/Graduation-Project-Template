<x-layout>
    @section('title',$user->name . ' - Complaints')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-blue font-medium text-sm mb-4 transition">
                <i class="fa-solid fa-arrow-left"></i> Back to Users
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Complaints By {{ $user->name }}</h1>
            <p class="text-sm text-gray-500 mt-1">Viewing all historical tickets submitted by this user.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th class="p-4 font-bold ">Ticket ID</th>
                            <th class="p-4 font-bold">Category</th>
                            <th class="p-4 font-bold">Status</th>
                            <th class="p-4 font-bold">Date Submitted</th>
                            <th class="p-4 font-bold text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($complaints as $complaint)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-mono text-sm text-gray-600">
                                    {{ str_pad($complaint->id,5,'0', STR_PAD_LEFT) }}
                                </td>
                                <td class="p-4 text-sm font-medium text-gray-900">
                                    <form action="{{ route('admin.users.complaints.update',$complaint->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $complaint->status }}">

                                        <select name="category_id" onchange="this.form.submit()" class="text-[13px] font-bold uppercase rounded-md text-gray-600 px-2 py-1.5 pl-2 bg-gray-100 border-gray-200 hover:border-brand-blue focus:ring-brand-blue focus:border-brand-blue pr-8 pointer transition">
                                            <option value="" disabled {{ !$complaint->category->id ? 'selected': '' }}>Uncategorized</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ $complaint->category_id == $category->id ? 'selected': '' }}>
                                                    {{ $category->name }}
                                                </option>

                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td class="p-4">
                                    <form action="{{ route('admin.users.complaints.update',$complaint->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="category_id" value="{{ $complaint->category_id }}">

                                        <select name="status" onchange="this.form.submit()" class="text-[10px] font-bold uppercase rounded-md text-gray-600 px-2 py-1.5 pl-2 bg-gray-100 border-gray-200 hover:border-brand-blue focus:ring-brand-blue focus:border-brand-blue pr-8 pointer transition">
                                            <option value="pending" {{ $complaint->status == 'pending' ? 'selected': '' }}>Pending</option>
                                            <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected': '' }}>In Progress</option>
                                            <option value="under_review" {{ $complaint->status == 'under_review' ? 'selected': '' }}>Under Review</option>
                                            <option value="approved" {{ $complaint->status == 'approved' ? 'selected': '' }}>Approved</option>
                                            <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected': '' }}>Resolved</option>
                                            <option value="reopened" {{ $complaint->status == 'reopened' ? 'selected': '' }}>Reopened</option>
                                            <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected': '' }}>Rejected</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="p-4 text-sm text-gray-500">
                                    {{ $complaint->created_at->format('M d, Y') }}
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('admin.users.complaints.show',$complaint->id) }}" class="text-brand-blue hover:underline text-sm font-bold">View Ticket</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500 text-sm">
                                    This user hasn't submitted any complaints yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($complaints->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $complaints->links() }}
                </div>
            @endif

        </div>
    </div>
</x-layout>
