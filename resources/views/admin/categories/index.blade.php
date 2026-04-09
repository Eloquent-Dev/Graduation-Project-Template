<x-layout>
    @section('title', 'manage Categories')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <div class="mb-8 flex flex-col md:flex-row justify-between md:items-center gap-4 border-b border-gray-200 pb-5">
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
                                        <a class="text-gray-400 hover:text-brand-blue transition p-2 bg-gray-50 hover:bg-blue-50 rounded-lg" href="{{ route('admin.categories.edit', $category->id) }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                        <form id="delete-category-form-{{ $category->id }}" action="{{route('admin.categories.destroy',$category->id)}}" method="post" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                onclick="openDeleteModal(this)"
                                                data-form-id="delete-category-form-{{ $category->id }}"
                                                data-item-name="{{ $category->name }}"
                                                class="w-8 h-8 bg-red-50 text-red-600 pointer transition p-2 hover:bg-red-100 hover:text-red-700 flex items-center justify-center rounded-lg" title="Delete Category">
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


    <div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center  transition-opacity duration-200">
        <div id="delete-modal-card" class="bg-white rounded-2xl p-6 max-w-sm w-full mx-4 shadow-2xl transform scale-95 transition-transform duration-200">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-red-100 mb-4">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-2xl"></i>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-2">Confirm Deletion</h3>

                <p class="text-sm text-gray-500 mb-6">
                    Are you sure you want to delete <span id="delete-items-name" class="font-bold text-gray-900 px-1 py-0.5 bg-gray-100 rounded"></span>? This action can't be undone.
                </p>

                <div class="flex justify-center gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-5 py-2.5 bg-gray-100 text-gray-700 hover:bg-gray-200 font-bold rounded-xl transition duration-150 pointer">
                        Cancel
                    </button>
                    <button type="button" id="confirm-delete-btn" class="px-5 py-2.5 bg-red-600 text-white hover:bg-red-700 font-bold rounded-xl transition duration-150 shadow-sm shadow-red-200 pointer">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
<script>
    let formToSubmitId= null;
    function openDeleteModal(buttonElement){
        formToSubmitId = buttonElement.getAttribute('data-form-id');
        const itemName = buttonElement.getAttribute('data-item-name');
        document.getElementById('delete-items-name').innerText = itemName;

        const modal = document.getElementById('delete-modal');
        const modalCard = document.getElementById('delete-modal-card');

        modal.classList.remove('hidden');
        modal.classList.add('flex')


        setTimeout(() => {
            modalCard.classList.remove('scale-95');
            modalCard.classList.add('scale-100');
        },10);
    }
function closeDeleteModal(){
    const modal = document.getElementById('delete-modal');
    const modalCard = document.getElementById('delete-modal-card');

    modalCard.classList.remove('scale-100');
    modalCard.classList.add('scale-95');

    setTimeout(()=>{
        modal.classList.remove('flex')
        modal.classList.add('hidden');

        formToSubmitId = null;
    },200);
}
document.getElementById('confirm-delete-btn').addEventListener('click',function(){
    if (formToSubmitId){
        document.getElementById(formToSubmitId).submit();
    }
});
document.getElementById('delete-modal').addEventListener('click',function(e){
    if (e.target=== this){
        closeDeleteModal();
    }
    });

</script>
</x-layout>
