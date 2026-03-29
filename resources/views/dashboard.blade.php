<x-layout>
    @section('title', 'My Dashboard')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">

        <div
            class="mb-8 flex flex-col md:flex-row justify-between md:items-end gap-4 bg-brand-dark rounded-2xl p-6 md:p-8 text-white shadow-lg relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none">
            </div>
            <div class="relative z-10">
                <h1 class="text-3xl font-black mb-1">Welcome back ,{{ explode(' ', trim($user->name))[0] }}!</h1>
                <p class="text-gray-300 text-sm">Track the progress and resolution times of your submitted
                    issues.</p>
            </div>

            <div class="relative z-10 text-sm font-bold text-gray-800 bg-white px-5 py-2.5 rounded-xl shadow-sm">
                <i class="fa-regular fa-calendar text-brand-blue mr-2"></i> {{ now()->format('l,F j,Y') }}
            </div>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div
                class="bg-white rounded-xl p-6 border-l-4 border-brand-blue shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Complaints</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $stats['total'] }}</h3>
                </div>
                <div class="bg-blue-50 w-12 h-12 rounded-full flex items-center justify-center text-brand-blue text-xl">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 border-l-4 border-red-500 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Awaiting Action</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $stats['pending'] }}</h3>
                </div>
                <div class="bg-red-50 w-12 h-12 rounded-full flex items-center justify-center text-red-500 text-xl">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
            <div
                class="bg-white rounded-xl p-6 border-l-4 border-green-500 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase traking-wider mb-1">Successfully Resolved</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $stats['resolved'] }}</h3>
                </div>
                <div class="bg-green-50 w-12 h-12 rounded-full flex items-center justify-center text-green-500 text-xl">
                    <i class="fa-solid fa-check-double"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden p-6">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Resolution Time</h3>
                    <p class="text-xs text-gray-500">Average time taken (in hours) for your complants to reach their
                        current status. </p>
                </div>
                <i class="fa-solid fa-chart-bar text-gray-300 text-3xl"></i>
            </div>
            <div class="relative h-80 w-full">
                <canvas id="timeChart"></canvas>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('timeChart').getContext('2d');
            const labels = {!! json_encode($chartLabels) !!};
            const data = {!! json_encode($chartData) !!};
            if (labels.length === 0) {
                document.getElementById('timeChart').parentElement.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full text-gray-400">
                    <i class ="fa-solid fa-chart-line text-4xl mb-3 text-gray-300"></i>
                    <p class ="text-sm font-medium">No data available yet.</p>
                    <p class ="text-xs mt-1">Submit a complaint to start generating.</p>
                    </div>
                    `;
                return;
            }
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Average Hours Taken',
                        data: data,
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgba(29, 78, 216, 1)',
                        borderWidth: 1,
                        borderRadius: 6,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Hours';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Hours Elapsed',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: '#f3f4f6'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Currnet Status of Complaint',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-layout>
