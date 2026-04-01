<x-layout>
    @section('title', 'Edit Profile')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        <a href="{{ route('citizen.profile.show') }}" class="inline-flex items-center gap-2 text-gary-500 hover:text-brand-blue font-medium text-sm mb-6 transition">
            <i class="fa-solid fa-arrow-left"></i> Back to Profile
        </a>
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
            <p class="text-sm mt-1 text-gray-500">Update your profile information and details.</p>
        </div>
        <div class="bg-white shadow-sm rounded-2xl border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center gap-3">
                <i class="fa-solid fa-user-pen text-gray-400"></i>
                <h3 class="font-bold text-gray-800">Profile Information</h3>
            </div>
            <form action="{{ route('citizen.profile.update') }}" method="POST" class="p-6 sm:p-8">
                @csrf
                @method('patch')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="sm:col-span-2">
                        <label for="edit_name" class="block text-sm font-bold text-gray-700 mb-1">
                            Full Name<span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="edit_name" id="edit_name" value="{{ old('edit_name', $user->name) }}" required
                        class="w-full rounded-xl border border-gray-300 shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue/20 px-4 py-2.5 transition @error('edit_name') border-red-500 ring-1 ring-red-500 @enderror">

                        @error('edit_name')
                            <p class="text-red-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="edit_email" class="block text-sm font-bold text-gray-700 mb-1">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="edit_email" id="edit_email" value="{{ old('edit_email', $user->email) }}" required
                        class="w-full rounded-xl border border-gray-300 shadow-sm focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 px-4 py-2.5 transition @error('edit_email') border-red-500 ring-1 ring-red-500 @enderror">
                        @error('edit_email')
                            <p class="text-red-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="edit_phone" class="block text-sm font-bold text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="edit_phone" id="edit_phone" value="{{ old('edit_phone', $user->phone) }}" placeholder="Enter phone number"
                        class="w-full rounded-xl border border-gray-300 shadow-sm focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 px-4 py-2.5 transition @error('edit_phone') border-red-500 ring-1 ring-red-500 @enderror">
                        @error('edit_phone')
                            <p class="text-red-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="edit_national_no" class="block text-sm font-bold text-gray-700 mb-1">National ID</label>
                        <input type="text" name="edit_national_no" id="edit_national_no" value="{{ old('edit_national_no', $user->national_no) }}" placeholder="Enter ID number"
                        class="w-full rounded-xl border border-gray-300 shadow-sm focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 px-4 py-2.5 transition @error('edit_national_no') border-red-500 ring-1 ring-red-500 @enderror">
                        @error('edit_national_no')
                            <p class="text-red-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>
                <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('citizen.profile.show') }}" class="px-5 py-2.5 text-sm font-bold border text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition">
                        Cancel</a>

                    <button type="submit" class="px-6 py-2.5 bg-brand-blue hover:bg-blue-800 text-white font-bold rounded-xl hover:shadow-lg transition flex items-center gap-2 pointer">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </div>
            </form>
            </div>

        </div>
    </div>

</x-layout>
