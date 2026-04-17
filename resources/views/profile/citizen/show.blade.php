<x-layout>
    @section('title', 'Citizen Profile Show')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        <div class ="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Citizen Profile</h1>
            <p class="text-sm mt-1 text-gray-500">View your profile information and details.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1">
                <div
                    class="bg-white shadow-sm rounded-2xl border border-gray-200 p-6 flex flex-col items-center text-center">
                    <div
                        class="w-32 h-32 rounded-full bg-brand-blue flex items-center justify-center text-white text-4xl font-bold mb-4 shadow-inner">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500 mb-4">Registered Citizen</p>

                    <div class="w-full mt-6 pt-6 border-t border-gray-100">
                        <p class="text-xs text-gray-400">Member since {{ $user->created_at->format('F Y') }} </p>

                    </div>
                </div>
            </div>
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white shadow-sm rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">
                            <i class="fa-solid fa-address-card text-gray-800"></i> Personal Information
                        </h3>
                        <a href="{{ route('citizen.profile.edit') }}"
                            class="text-sm text-brand-blue hover:text-blue-800 font-medium transition">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Edit</a>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6">
                            <div>
                                <dt class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Full Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Email Address
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Phone Number
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->phone ?? 'Not Provided' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">National ID
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->national_no ?? 'Not Provided' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-shield-halved text-gray-400"></i>
                            Security
                        </h3>
                    </div>
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-gray-900">Password</p>
                            <p class="text-xs text-gray-500 mt-1">Ensure your account is using a long, random password
                                to stay secure</p>
                        </div>
                        <button type="button" id="openPasswordBtn"
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-lg transition text-sm pointer">
                            Change Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="passwordModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 sm:p-6">
            <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity opacity-0"
                id="modalBackdrop"></div>
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md  overflow-hidden z-10 transition scale-95 opacity-0 transition-all duration-300"
                id="modalContent">
                <div class="px-4 py-4 border-b border-gray-100 flex justify-between items-center gap-2">
                    <i class="fa-solid fa-lock text-brand-blue"></i> Update Password
                    <button type="button" id="closePasswordBtn"
                        class="text-gray-400 hover:text-red-500 transition pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <form action="{{ route('citizen.profile.password.update') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('patch')
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Current Password</label>
                        <input type="password" name="current_password"
                            class="w-full rounded-xl shadow-sm focus:border-brand-blue focus:ring-1 outline-none focus:ring-brand-blue/50 px-4 py-2.5">
                        @error('current_password')
                            <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }} </span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">New Password</label>
                        <input type="password" name="new_password"
                            class="w-full rounded-xl shadow-sm focus:border-brand-blue focus:ring-1 outline-none focus:ring-brand-blue/50 px-4 py-2.5">
                        @error('new_password')
                            <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }} </span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation"
                            class="w-full rounded-xl shadow-sm focus:border-brand-blue focus:ring-1 outline-none focus:ring-brand-blue/50 px-4 py-2.5">
                    </div>
                    <div class="pt-4 flex justify-end gap-3">

                        <button type="submit"
                            class="px-6 py-2.5 bg-brand-blue hover:bg-blue-800 text-white font-bold rounded-xl shadow-md transition flex items-center gap-2 pointer">
                            <i class="fa-solid fa-check"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const openBtn = document.getElementById('openPasswordBtn');
                const closeBtn = document.getElementById('closePasswordBtn');
                const cancelBtn = document.getElementById('cancelPasswordBtn');
                const modal = document.getElementById('passwordModal');
                const backdrop = document.getElementById('modalBackdrop');
                const content = document.getElementById('modalContent');

                function openPasswordModal() {
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        backdrop.classList.remove('opacity-0');
                        content.classList.remove('opacity-0', 'scale-95');
                        content.classList.add('opacity-100', 'scale-100');
                    }, 10);
                }

                function closePasswordModal() {
                    backdrop.classList.add('opacity-0');
                    content.classList.remove('opacity-100', 'scale-100');
                    content.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                    }, 300);
                }
                if (openBtn) openBtn.addEventListener('click', openPasswordModal);
                if (closeBtn) closeBtn.addEventListener('click', closePasswordModal);
                if (cancelBtn) cancelBtn.addEventListener('click', closePasswordModal);
                if (backdrop) backdrop.addEventListener('click', closePasswordModal);
                @if ($errors->has('current-password') || $errors->has('new_password') || $errors->has('new_password_confirmation'))
                    openPasswordModal();
                @endif
            });
        </script>
    </div>
</x-layout>
