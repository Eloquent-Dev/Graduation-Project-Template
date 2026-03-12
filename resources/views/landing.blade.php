<x-layout>
    @section('title','Welcome To City Voice')
    <section class="relative h-[600px] flex items-center -mt-8 -mx-6 lg:-mx-8">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
             alt="City Skyline"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-blue-900/40"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 w-full mt-10">
        <div class="max-w-2xl">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight drop-shadow-md">
                City Voice: Empowering Smart Cities
            </h1>
            <p class="text-lg text-white/90 mb-8 font-medium drop-shadow-sm">
                Report • Track • Resolve <span class="font-light">Municipal Complaints Efficiently</span>
            </p>

            <div class="flex flex-wrap gap-4 items-center">
                <a href="{{ route('complaints.create') }}" class="bg-brand-orange hover:bg-orange-600 text-white px-8 py-3 rounded shadow-lg font-bold transition transform hover:-translate-y-0.5">
                    Submit a Complaint
                </a>
                <a href="#features" class="text-white hover:text-brand-orange font-medium flex items-center gap-2 transition">
                    Learn More <i class="fa-solid fa-chevron-down text-xs"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<div class="relative z-19 -mt-16 max-w-7xl mx-auto mb-20">
    <div class="bg-white rounded-lg shadow-xl grid grid-cols-1 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-gray-100 p-6">

        <div class="flex items-start gap-4 p-4">
            <div class="bg-blue-50 p-3 rounded-full text-brand-blue">
                <i class="fa-solid fa-mobile-screen-button text-xl w-6 text-center"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Easy Submission</h3>
                <p class="text-xs text-gray-500 mt-1">Report issues with pinpoint accuracy.</p>
            </div>
        </div>

        <div class="flex items-start gap-4 p-4">
            <div class="bg-blue-50 p-3 rounded-full text-brand-blue">
                <i class="fa-solid fa-magnifying-glass-location text-xl w-6 text-center"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Live Tracking</h3>
                <p class="text-xs text-gray-500 mt-1">Monitor the progress in real time.</p>
            </div>
        </div>

        <div class="flex items-start gap-4 p-4">
            <div class="bg-blue-50 p-3 rounded-full text-brand-blue">
                <i class="fa-solid fa-network-wired text-xl w-6 text-center"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Smart Assignment</h3>
                <p class="text-xs text-gray-500 mt-1">Tasks directed to the right teams.</p>
            </div>
        </div>

        <div class="flex items-start gap-4 p-4">
            <div class="bg-blue-50 p-3 rounded-full text-brand-blue">
                <i class="fa-solid fa-clipboard-check text-xl w-6 text-center"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Verified Resolution</h3>
                <p class="text-xs text-gray-500 mt-1">Ensure every issue is resolved.</p>
            </div>
        </div>

    </div>
</div>

<section id="features" class="max-w-7xl mx-auto mb-24">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
            <div class="bg-gray-50 p-4 border-b border-gray-100 text-center">
                <h3 class="font-bold text-brand-blue text-lg">For Citizens</h3>
            </div>
            <div class="p-6">
                <ul class="space-y-4">
                    <li class="flex items-center gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-check text-green-500"></i> Simple Reporting
                    </li>
                    <li class="flex items-center gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-check text-green-500"></i> Real-Time Updates
                    </li>
                    <li class="flex items-center gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-check text-green-500"></i> Feedback & Evaluation
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
            <div class="bg-gray-50 p-4 border-b border-gray-100 text-center">
                <h3 class="font-bold text-brand-blue text-lg">For Authorities</h3>
            </div>
            <div class="p-6">
                <ul class="space-y-4">
                    <li class="flex items-center gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-check text-green-500"></i> Centralized Dashboard
                    </li>
                    <li class="flex items-center gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-check text-green-500"></i> Analytics & Insights
                    </li>
                    <li class="flex items-center gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-check text-green-500"></i> Improved Efficiency
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
            <div class="bg-gray-50 p-4 border-b border-gray-100 text-center">
                <h3 class="font-bold text-brand-blue text-lg">For Field Teams</h3>
            </div>
            <div class="p-6">
                <ul class="space-y-4">
                    <li class="flex items-center gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-check text-green-500"></i> Clear Work Orders
                    </li>
                    <li class="flex items-center gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-check text-green-500"></i> GPS-Based Tasks
                    </li>
                    <li class="flex items-center gap-3 text-sm text-gray-600">
                        <i class="fa-solid fa-check text-green-500"></i> Mobile Access
                    </li>
                </ul>
            </div>
        </div>

    </div>
</section>

<section class="relative bg-white py-16 overflow-hidden rounded-2xl border border-gray-100 shadow-sm mb-12">
    <div class="absolute top-0 right-0 w-2/3 h-full opacity-10 pointer-events-none">
         <img src="https://t4.ftcdn.net/jpg/02/76/89/65/360_F_276896574_f448x257r5k14064567.jpg" class="w-full h-full object-cover">
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-16">

            <div class="lg:w-1/2">
                <h2 class="text-3xl font-bold text-brand-blue mb-2">Building Trust <span class="font-normal text-gray-500">Through Technology</span></h2>
                <p class="text-gray-600 mb-8 mt-4 leading-relaxed">
                    Transforming complaint management for a smarter city. We leverage GIS technology and data analytics to ensure transparency and accountability in municipal services.
                </p>

                <div class="flex gap-4">
                    @auth
                        <a href="{{ route('complaints.create') }}" class="bg-brand-blue hover:bg-blue-800 text-white px-6 py-2.5 rounded shadow font-semibold text-sm transition">
                            Submit Report
                        </a>
                    @else
                        <button onclick="document.getElementById('open-auth-btn').click()" class="bg-brand-blue hover:bg-blue-800 text-white px-6 py-2.5 rounded shadow font-semibold text-sm transition">
                            Get Started
                        </button>
                    @endauth

                    <a href="#" class="bg-white border border-gray-300 hover:border-brand-blue hover:text-brand-blue text-gray-700 px-6 py-2.5 rounded shadow-sm font-semibold text-sm transition">
                        Track Your Complaint
                    </a>
                </div>
            </div>

            <div class="lg:w-1/2 relative h-64 lg:h-80 w-full hidden md:block">
                <div class="absolute top-10 left-10 text-brand-orange animate-bounce">
                    <i class="fa-solid fa-location-dot text-4xl drop-shadow-lg"></i>
                </div>
                <div class="absolute bottom-10 left-1/2 text-brand-blue">
                    <i class="fa-solid fa-location-dot text-4xl drop-shadow-lg"></i>
                </div>

                <div class="glass-card absolute top-0 right-0 w-48 p-3 rounded-lg">
                    <div class="h-2 w-12 bg-gray-200 rounded mb-2"></div>
                    <div class="flex items-end gap-1 h-12">
                        <div class="bg-blue-500 w-3 h-6 rounded-t"></div>
                        <div class="bg-blue-300 w-3 h-8 rounded-t"></div>
                        <div class="bg-brand-orange w-3 h-10 rounded-t"></div>
                        <div class="bg-blue-500 w-3 h-5 rounded-t"></div>
                    </div>
                </div>

                <div class="glass-card absolute bottom-4 right-12 w-56 p-3 rounded-lg flex items-center gap-3">
                    <div class="relative w-12 h-12 rounded-full border-4 border-blue-100 border-t-brand-orange flex items-center justify-center">
                        <span class="text-[8px] font-bold">75%</span>
                    </div>
                    <div>
                        <div class="h-2 w-20 bg-gray-200 rounded mb-1"></div>
                        <div class="h-2 w-12 bg-gray-200 rounded"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

</x-layout>

