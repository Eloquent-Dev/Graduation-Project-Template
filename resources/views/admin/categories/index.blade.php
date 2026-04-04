<x-layout>
    @section('title', 'manage Categories')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <div class="mb-8 flex flex-col md:flex-row justify-between md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Issue Categories</h1>
                <p class="text-sm text-gray-500 mt-1">Manage the types of complaints citizens are allowed to submit.</p>
            </div>
            <a href="{{route('admin.categories.create')}}"
                class="bg-brand-blue hover:bg-blue-800 text-white font-bold px-5 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 text-sm w-fit">
                <i class="fa-solid fa-plus"></i> Add New Category
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th class="p-4 font-bold w-16 text-center">ID</th>
                            <th class="p-4 font-bold w-full">Category Name</th>
                            <th class="p-4 font-bold text-center">Total Complaints</th>
                            <th class="p-4 font-bold text-center">Added On</th>
                            <th class="p-4 font-bold text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="p-4 text-center font-bold text-gray-400 text-sm">
                                    #{{ $category->id }}
                                </td>

                                <td class="p-4">
                                    <span class="font-bold text-brand-blue bg-blue-50 px-3 py-1.5 rounded-lg text-sm">
                                        <a class="hover:underline" href="{{route('admin.categories.show',$category->id)}}">{{ $category->name }}</a>
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <div
                                        class="inline-flex items-center justify-center bg-gray-100 text-gray-700 font-bold text-xs h-8 w-8 rounded-full shadow-inner">
                                        {{ $category->complaints_count ?? 0 }}
                                    </div>
                                </td>

                                <td class="p-4 text-center text-sm text-gray-500 font-medium">
                                    {{ $category->created_at->format('M d, Y') }}
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            class="text-gray-400 hover:text-brand-blue transition p-2 bg-gray-50 hover:bg-blue-50 rounded-lg">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                        <form action="{{route('admin.categories.destroy',$category->id)}}" method="post" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                            class="text-gray-400 hover:text-red-500 transition p-2 bg-gray-50 hover:bg-red-50 rounded-lg">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-400">
                                    <p class="text-sm font-medium">No categories found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($categories->hasPages())
                <div class="p-4 border-t border-gray-200 bg-gray-50">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layout>
