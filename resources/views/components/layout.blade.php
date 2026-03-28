<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>City Voice - @yield('title', 'Smart Complaint Management')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased flex flex-col min-h-screen">
    <nav class="w-full z-50 sticky top-0 left-0 bg-linear-to-r from-brand-dark to-brand-blue shadow-lg border-b border-blue-800">

        <div class="mx-auto px-6 lg:px-8">
            <div id="menu-backdrop" class="fixed top-20 left-0 w-full h-[calc(100vh-5rem)] bg-gray-900/60 z-30 opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out"></div>
            <div id="side-menu" class="fixed top-20 left-0 w-72 bg-linear-to-r from-[#0e162a] to-[#11203f] h-[calc(100vh-5rem)] border-t border-white shadow-2xl z-40 transform -translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">
                <div class="px-4 py-6 space-y-1 flex flex-col h-full">
                    <a href="{{ route('home') }}" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-home w-5 text-center"></i> Home
                    </a>
                    @auth
                    <a href="#" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-table-columns w-5 text-center"></i> Dashboard
                    </a>
                    <a href="{{ route('complaints.index') }}" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-file-circle-exclamation w-5 text-center"></i> My Complaints
                    </a>
                    @endauth
                    @if(auth()->check() && in_array(auth()->user()->role,['worker','supervisor']))
                    <a href="{{ route('worker.assignments') }}" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-clipboard-check w-5 text-center"></i> My Assignments
                    </a>
                    @endif
                    @if(auth()->check() && auth()->user()->role === 'dispatcher')
                    <a href="{{ route('dispatcher.job_orders.index') }}" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-satellite-dish w-5 text-center"></i> Dispatch Queue
                    </a>
                    @endif
                    @if(auth()->check() && auth()->user()->role === 'supervisor')
                    <a href="{{ route('supervisor.reports.index') }}" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-file-circle-check w-5 text-center"></i> Completion Reports
                    </a>
                    @endif
                    @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-users w-5 text-center"></i> Users
                    </a>
                    <a href="#" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-layer-group w-5 text-center"></i> Categories
                    </a>
                    <a href="#" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-chart-line w-5 text-center"></i> Admin Reports
                    </a>
                    @endif
                    <a href="{{ route('complaints.create') }}" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-plus w-5 text-center"></i> Submit Complaint
                    </a>
                    @auth
                    <div class="mt-auto">
                        <div class="border-t border-white my-4 flex items-end"></div>
                    <a href="#" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                       <i class="fa-solid fa-gear"></i> Account Settings
                    </a>
                    </div>
                    @endauth

                </div>
            </div>

            <div class="flex items-center justify-between h-20">
                <div class="flex justify-between items-center gap-10">
                    <div class="ham-menu flex">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    @auth
                    <div class="relative">
                        <button type="button" id="notification-btn" class="relative text-white hover:text-brand-orange transition focus:outline-none ml-2 mt-1">
                        <i class="fa-regular fa-bell text-xl cursor-pointer"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute -top-1 -right-1 flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75 cursor-pointer pointer-events-none"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 border-2 border-white cursor-pointer"></span>
                        </span>
                        @endif
                    </button>

                    <div id="notification-dropdown" class="hidden absolute max-h-112 left-0 mt-4 w-80 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
                        <div class="bg-gray-50 border-b border-gray-100 px-4 py-3 flex justify-between items-center">
                            <h3 class="text-sm font-bold tetx">Notifications</h3>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                {{ auth()->user()->unreadNotifications->count() }} New
                            @endif
                        </div>

                        <div class="max-h-80 overflow-y-auto">
                            @forelse (auth()->user()->notifications()->take(10)->get() as $notification)
                                <a href="{{ route('notifications.read',$notification->id) }}" class="block px-4 py-3 hover:bg-blue-50 border-b border-gray-50 transition group">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800 group-hover:text-brand-blue"><i class="fa-solid fa-{{ $notification->data['icon'] }} text-brand-blue text-sm"></i> {{ $notification->data['title'] }}</p>
                                        <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ $notification->data['message'] }}</p>
                                        <p class="text-[10px] text-gray-400 mt-2 font-medium">{{$notification->created_at->diffForHumans()}}</p>
                                    </div>
                                </a>
                            @empty
                                <div class="px-4 py-8 text-center text-gray-400">
                                    <i class="fa-regular fa-bell-slash text-2xl mb"></i>
                                    <p class="text">You're all caught up!</p>
                                </div>
                            @endforelse
                        </div>
                        @if(auth()->user()->notifications()->count() > 0)
                                <div class="bg-gray-50 border-t border-gray-100 px-4 py-2 text-center">
                                    <form action="{{ route('notifications.markAllRead') }}" method="get">
                                        @csrf
                                        <button class="text-xs text-brand-orange font-bold hover:underline pointer" type="submit">Mark all as read</button>
                                    </form>
                                </div>
                        @endif
                        </div>
                    </div>
                    @endauth
                </div>
                <div class="flex items-center gap-2">

                    <div class="bg-white/10 backdrop-blur p-1 rounded border border-white/20">
                        <i class="fa-solid fa-city text-white text-2xl"></i>
                    </div>

                    <div>
                        <h1 class="text-white font-bold text-xl leading-none">City Voice</h1>
                        <p class="text-blue-200 text-[10px] tracking-wider uppercase">Smart Complaint Management System</p>
                    </div>
                </div>
                @guest
                <div>
                    <form action="{{ route('logout') }}">
                        @csrf
                    <a href="#" id="open-auth-btn" class="md:inline-block cursor-pointer bg-brand-orange hover:bg-orange-600 text-white px-6 py-2 rounded shadow-lg transition font-semibold text-sm">
                        Sign In
                    </a>
                    </form>
                </div>
                @endguest
                @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="md:inline-block cursor-pointer bg-brand-orange hover:bg-orange-600 text-white px-6 py-2 rounded shadow-lg transition font-semibold text-sm">
                        Sign out
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </nav>
    <div class="fixed top-24 left-4 z-20 flex flex-col gap-3 w-full">
        @if(session('success'))
        <div class="max-w-8xl px-6 lg:px-8 mt-4 alert-wrapper">
            <div class="bg-green-100 border-l-4 border-green-500 w-full text-green-700 p-4 rounded shadow-sm flex justify-between items-center" role="alert">
                <p>{{ session('success') }}</p>
                <button type="button" onclick="this.closest('.alert-wrapper').remove()" class="close-alert-btn text-green-700 hover:text-green-900 cursor-pointer transition focus:outline-none p-1" aria-label="Close">
                    <i class="fa-solid fa-xmark text-lg text-[24px] pointer-events-none"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-8xl px-6 lg:px-8 mt-4 alert-wrapper">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex justify-between items-center" role="alert">
                <p>{{ session('error') }}</p>
                <button type="button" onclick="this.closest('.alert-wrapper').remove()" class="close-alert-btn text-green-700 hover:text-green-900 cursor-pointer transition focus:outline-none p-1" aria-label="Close">
                    <i class="fa-solid fa-xmark text-lg text-[24px] pointer-events-none"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('warning') && is_null(auth()->user()->national_no))
        <div class="max-w-8xl px-6 lg:px-8 mt-4 alert-wrapper">
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow-sm flex justify-between items-center" role="alert">
                <p>{{ session('warning') }}</p>
                <button type="button" onclick="this.closest('.alert-wrapper').remove()" class="close-alert-btn text-green-700 hover:text-green-900 cursor-pointer transition focus:outline-none p-1" aria-label="Close">
                    <i class="fa-solid fa-xmark text-lg text-[24px] pointer-events-none"></i>
                </button>
            </div>
        </div>
    @endif
    </div>

    <main class="grow flex flex-col w-full">
        {{ $slot }}
    </main>

    <footer class="bg-linear-to-r from-brand-dark to-brand-blue border-t border-gray-700 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <p class="text-sm text-gray-300">City Voice - Empowering Smart Cities</p>
            <p class="text-xs text-gray-300 mt-2">&copy; {{ date('Y') }} - All Rights Reserved.</p>
        </div>
    </footer>
    @php
    $autoOpenView = '';
    if(auth()->check() && (is_null(auth()->user()->national_no) || is_null(auth()->user()->phone))){
        $autoOpenView = 'oauth';
    }
    elseif($errors->has('name')|| $errors->has('national-no')||$errors->has('register-email')||$errors->has('phone_full')||$errors->has('register-password')){
        $autoOpenView = 'register';
    }elseif($errors->has('login-email') || $errors->has('login-password')){
        $autoOpenView = 'login';
    }elseif(session('openLoginModal')){
        $autoOpenView = 'login';
    }
    @endphp

    <div id="auth-modal" data-auto-open="{{ $autoOpenView }}" class="fixed inset-0 z-100 hidden flex items-center justify-center bg-gray-900/90 transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto relative">
            <button id="close-auth-btn" class="absolute top-4 left-4 text-gray-400 hover:text-gray-600 focus:outline:none transition cursor-pointer">
                <i class="fa-solid fa-xmark text-xl pointer-events-none"></i>
            </button>

            <div id="login-view" class="p-8">
                <h2 class="text-2xl font-bold text-brand-dark mb-6 text-center">Welcome Back</h2>
                <!-- OAuth Buttons -->
            <div class="space-y-4">
                <!-- Google Button -->
                <a href="{{ route('google.redirect') }}" class="pointer w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition-all duration-200 hover:border-slate-500 hover:shadow-lg">
                    <img src="{{ asset('images/google_logo.png') }}" alt="Google Logo" class="w-5 h-5 mr-2" />
                    <span class="text-gray-700 font-medium">Continue with Google</span>
                </a>

                <!-- Microsoft Button -->
                <a href="{{ route('microsoft.redirect') }}" class="pointer w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition-all duration-200 hover:border-slate-500 hover:shadow-lg">
                    <img src="{{ asset('images/Microsoft_logo.png') }}" alt="Microsoft Logo" class="w-5 h-5 mr-3" />
                    <span class="text-gray-700 font-medium">Continue with Microsoft</span>
                </a>

                <!-- Divider -->
                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">or continue with email</span>
                    </div>
                </div>
            </div>
                <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address:</label>
                        <input value="{{ old('login-email') }}" type="email" name="login-email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition">
                        @error('login-email')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password:</label>
                        <input type="password" name="login-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition">
                        @error('login-password')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-brand-blue hover:bg-blue-800 text-white font-bold py-3 rounded-lg shadow transition mt-2 cursor-pointer">
                        Sign In
                    </button>
                </form>
                <p class="mt-6 text-sm text-center text-gray-600">
                    Don't have an account?
                    <button id="show-register-btn" class="text-brand-orange font-bold hover:underline focus:outline-none cursor-pointer">
                        Sign up here
                    </button>
                </p>
            </div>

            <div id="register-view" class="p-8 hidden">
                <h2 class="text-2xl font-bold text-brand-dark mb-6 text-center">Create an Account</h2>

                <!-- OAuth Buttons -->
            <div class="space-y-4">
                <!-- Google Button -->
                <a href="{{ route('google.redirect') }}" class="pointer w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition-all duration-200 hover:border-slate-500 hover:shadow-lg">
                    <img src="{{ asset('images/google_logo.png') }}" alt="Google Logo" class="w-5 h-5 mr-3" />
                    <span class="text-gray-700 font-medium">Continue with Google</span>
                </a>

                <!-- Microsoft Button -->
                <a href="{{ route('microsoft.redirect') }}" class="pointer w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition-all duration-200 hover:border-slate-500 hover:shadow-lg">
                    <img src="{{ asset('images/Microsoft_logo.png') }}" alt="Microsoft Logo" class="w-5 h-5 mr-3" />
                    <span class="text-gray-700 font-medium">Continue with Microsoft</span>
                </a>

                <!-- Divider -->
                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">or continue with email</span>
                    </div>
                </div>
            </div>
                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name:</label>
                        <input type="text" value="{{ old('name') }}" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition">
                        @error('name')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">National Number:</label>
                        <input type="text" value="{{ old('national-no') }}" name="national-no" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition">
                        @error('national-no')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
                        <input type="email" value="{{ old('register-email') }}" name="register-email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition">
                        @error('register-email')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number:</label>
                        <input id="phone-1" type="tel" value="{{ old('phone_full') }}" name="phone_full" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition">
                        <input type="hidden" value="{{ old('country_code') }}" id="country_code" name="country_code">
                        @error('phone_full')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password:</label>
                        <input type="password" name="register-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition">
                        @error('register-password')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password:</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition">
                        @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-brand-blue hover:bg-blue-800 text-white font-bold py-3 rounded-lg shadow transition mt-2 cursor-pointer">
                        Create Account
                    </button>
                </form>
                <p class="mt-6 text-sm text-center text-gray-600">
                    Already have an account?
                    <button id="show-login-btn" class="text-brand-orange font-bold hover:underline focus:outline-none cursor-pointer">
                        Sign In here
                    </button>
                </p>
            </div>
            <div id="oauth-complete-view" class="p-8 hidden">
                <h2 class="text-2xl font-bold text-brand-dark mb-2 text-center">Almost Done!</h2>
                <p class="text-sm text-gray-600 mb-6 text-center">We just need a few official details to secure your account.</p>
                <form action="{{ route('oauth.finish') }}" method="post" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">National Number:</label>
                        <input type="text" value="{{ old('national-no') }}" name="national-no" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition">
                        @error('national-no')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number:</label>
                        <input id="phone-2" type="tel" value="{{ old('phone_full') }}" name="phone_full" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition">
                        <input type="hidden" value="{{ old('country_code') }}" id="country_code" name="country_code">
                        @error('phone_full')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-brand-blue hover:bg-blue-800 text-white font-bold py-3 rounded-lg shadow transition mt-2 cursor-pointer">
                        Complete Registeration
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
