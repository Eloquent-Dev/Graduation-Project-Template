<x-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 w-full">
        <div class="flex justify-between items-center mb-8 p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fa-solid fa-users-gear text-brand-orange text-3xl mr-3"></i>
                 Live Dispatch Tracking
            </h2>
            <div class="flex gap-4 text-sm font-medium">
              <div class="flex items-center gap-2 px-3 py-1 bg-green-50 text-green-700 rounded-full">
                <span class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></span> Auto-sync Active
              </div>
            </div>
        </div>
        <div id="tracking-container" class="space-y-4">
            <div class="flex justify-center p-10">
                <i class="fa-solid fa-circle-notch fa-spin text-4xl text-brand-blue"></i>
            </div>
        </div>
    </div>
    <script>
        const openAccordion = new Set()

        function toggleAccordion(id){
            const content = document.getElementById(`content-${id}`)
            const icon = document.getElementById(`icon-${id}`)

            if(openAccordion.has(id)){
                openAccordion.delete(id)
                content.classList.add('hidden')
                icon.classList.remove('rotate-180')
            }else{
                openAccordion.add(id)
                content.classList.remove('hidden')
                icon.classList.add('rotate-180')
            }
        }

        function formatStatus(status){
            if(!status) return 'Pending';
            return status.replace('_',' ').replace(/\b\w/g, l => l.toUpperCase())
        }

        function getWorkerStatusBadge(status){
            let colorClasses = 'bg-blue-100 text-blue-700 border border-blue-200'

            if(status === 'in_route') colorClasses = 'bg-yellow-100 text-yellow-700 border border-yellow-200'
            else if(status === 'on_site') colorClasses = 'bg-orange-100 text-orange-700 border border-orange-200'
            else if(status === 'off_site') colorClasses = 'bg-gray-100 text-gray-700 border border-gray-200'

            return `<span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider ${colorClasses}">${ formatStatus(status) }</span>`
        }

        function getDutyStatusBadge(status){
            let colorClasses = 'bg-gray-100 text-gray-700 border border-gray-200'

            if(status === 'on_duty') colorClasses = 'bg-green-100 text-green-700 border border-green-200'
            else if(status === 'off_duty') colorClasses = 'bg-red-100 text-red-700 border border-red-200'

            return `<span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider ${colorClasses}">${formatStatus(status)}</span>`
        }

        function fetchTrackingData(){
            fetch('{{ route('tracking.data') }}')
                .then(response => response.json())
                .then(jobOrders => {
                    const container = document.getElementById('tracking-container')
                    let html = ''

                    if(jobOrders.length === 0){
                        container.innerHTML = `
                        <div class="text-center p-12 bg-white rounded-2xl shadow-sm border border-gray-100">
                            <i class="fa-solid fa-clipboard-check text-5xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-bold text-gray-800"> No Active Dispatchers</h3>
                            <p class="text-sm text-gray-500 mt-1"> There are currently no job orders with assigned workers.</p>
                            </div>`;
                            return;
                    }

                    jobOrders.forEach(order => {
                        const isOpen = openAccordion.has(order.id)
                        const hiddenClass = isOpen ? '' : 'hidden'
                        const rotateClass = isOpen ? 'rotate-180' : ''

                        let workerRows = ''

                        order.workers.forEach(worker => {
                            workerRows+= `<tr class="border-b border-gray-100 last:border-0 hover-bg-gray-50 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-brand-blue/10 text-brand-blue flex items-center justify-center font-bold mr-3 shadow-inner">
                                            ${worker.name ? worker.name.charAt(0) : '?'}
                                        </div>
                                        <span class="font-semibold text-gray-800 text-sm">${worker.name || 'Unknown'}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">${getWorkerStatusBadge(worker.worker_status)}</td>
                                <td class="px-6 py-4">${getDutyStatusBadge(worker.duty_status)}</td>
                            </tr>`;
                        });

                        html += `
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden transition-all duration-200 hover:shadow-md mb-4">
                            <button onclick="toggleAccordion(${order.id})" class="w-full px-6 py-5 flex flex-col sm:flex-row justify-between sm:items-center bg-gray-50/50 hover:bg-gray-50 transition focus:outline-none pointer">
                                <div class="flex items-center gap-4 mb-2 sm:mb-0">
                                    <span class="bg-brand-dark text-white w-10 h-10 rounded-xl shadow flex items-center justify-center font-bold text-sm border border-gray-700 shrink-0">
                                        #${order.id}
                                    </span>
                                    <div class="text-left">
                                        <h4 class="font-bold text-gray-900 text-base">Job Order (Complaint #${order.complaint_id})</h4>
                                        <p class="text-xs font-semibold text-gray-500 mt-0.5"><span class="text-brand-orange">${order.priority.toUpperCase()}</span> Priority</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-5 ml-14 sm:ml-0">
                                    <div class="flex -space-x-2">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center border-2 border-white shadow-sm z-10 text-xs font-bold text-brand-blue">
                                            <i class="fa-solid fa-users"></i>
                                        </div>
                                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center border-2 border-white shadow-sm z-0 text-xs font-bold text-gray-600 pl-2">
                                            ${order.workers.length}
                                        </div>
                                    </div>
                                    <div class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 shadow-sm">
                                        <i id="icon-${order.id}" class="fa-solid fa-chevron-down text-gray-500 transition-transform duration-300 ${rotateClass}"></i>
                                    </div>
                                </div>
                            </button>
                            <div id="content-${order.id}" class="${hiddenClass} border-t border-gray-200 bg-white">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-gray-50/50 text-gray-500 text-[10px] uppercase tracking-widest border-b border-gray-200">
                                                <th class="px-6 py-3 font-bold">Employee Directory</th>
                                                <th class="px-6 py-3 font-bold">Current Worker Status</th>
                                                <th class="px-6 py-3 font-bold">Shift Duty Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${workerRows || '<tr><td colspan="3" class="px-6 py-8 text-center text-gray-400 text-sm font-medium"><i class="fa-solid fa-user-xmark text-2xl mb-2 block"></i> No personnel assigned yet.</td></tr>'}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>`;
                    });

                    container.innerHTML = html;
                })
                .catch(error => console.error('Error fetching tracking data:', error))
        }

        document.addEventListener('DOMContentLoaded',() =>{
            fetchTrackingData()
            setInterval(fetchTrackingData,3000)
        })
    </script>
 </x-layout>
