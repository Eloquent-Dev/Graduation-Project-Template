<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>City Voice - @yield('title', 'Smart Complaint Management')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased flex flex-col min-h-screen">
    <nav class="w-full z-50 sticky top-0 left-0 bg-linear-to-r from-brand-dark to-brand-blue shadow-lg border-b border-blue-800">

        <div class="mx-auto px-6 lg:px-8">
            <div id="menu-backdrop" class="fixed top-20 left-0 w-full h-[calc(100vh-5rem)] bg-gray-900/60 z-30 opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out"></div>
            <div id="side-menu" class="fixed top-20 left-0 w-72 bg-linear-to-r from-[#0e162a] to-[#11203f] h-[calc(100vh-5rem)] border-t border-white shadow-2xl z-40 transform -translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">
                <div class="px-4 py-6 space-y-1 flex flex-col h-full">
                    @guest
                    <a href="{{ route('home') }}" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-home w-5 text-center"></i> Home
                    </a>
                    @endguest
                    @auth
                    <a href="#" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-table-columns w-5 text-center"></i> Dashboard
                    </a>
                    <a href="#" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-file-circle-exclamation w-5 text-center"></i> My Complaints
                    </a>
                    @endauth
                    @if(auth()->check() && auth()->user()->role === 'worker')
                    <a href="#" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-clipboard-check w-5 text-center"></i> My Assignements
                    </a>
                    <a href="#" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-users-gear w-5 text-center"></i> Worker Panel
                    </a>
                    @endif
                    @if(auth()->check() && auth()->user()->role === 'dispatcher')
                    <a href="#" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-paper-plane w-5 text-center"></i> Dispatch Job
                    </a>
                    @endif
                    @if(auth()->check() && auth()->user()->role === 'supervisor')
                    <a href="#" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-user-tie w-5 text-center"></i> Supervisor Panel
                    </a>
                    <a href="#" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-file-circle-check w-5 text-center"></i> Completion Reports
                    </a>
                    @endif
                    @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="#" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-users w-5 text-center"></i> Users
                    </a>
                    <a href="#" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-layer-group w-5 text-center"></i> Categories
                    </a>
                    <a href="#" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-chart-line w-5 text-center"></i> Admin Reports
                    </a>
                    @endif
                    @guest
                    <a href="#" class="px-4 py-3 rounded-md text-sm font-medium text-white hover:text-brand-orange hover:bg-white/5 transition flex items-center gap-3">
                        <i class="fa-solid fa-plus w-5 text-center"></i> Submit Complaint
                    </a>
                    @endguest
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
                    <button class="relative text-white hover:text-brand-orange transition focus:outline-none ml-2 mt-1">
                        <i class="fa-regular fa-bell text-xl cursor-pointer"></i>
                        <span class="absolute -top-1 -right-1 flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75 cursor-pointer"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 border-2 border-white cursor-pointer"></span>
                        </span>
                    </button>
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

                <div>
                    <a href="#" class="md:inline-block bg-brand-orange hover:bg-orange-600 text-white px-6 py-2 rounded shadow-lg transition font-semibold text-sm">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <main class="grow max-w-7xl mx-auto px-6 lg:px-8 py-8 w-full">
        @yield('content')
    </main>

    <footer class="bg-linear-to-r from-brand-dark to-brand-blue border-t border-gray-700 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <p class="text-sm text-gray-300">City Voice - Empowering Smart Cities</p>
            <p class="text-xs text-gray-300 mt-2">&copy; {{ date('Y') }} - All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
