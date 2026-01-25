@extends('layouts.public')

@section('title', 'ವರದಿ - Reports')

@section('nav_title')
    ವರದಿ (Reports)
@endsection

@section('content')

<div class="card card-style mt-n5">
    <div class="content pt-3">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-start">
                <h4 class="font-700 mb-1">ದೂರುಗಳ ವರದಿ</h4>
                <p class="font-11 opacity-70 mb-0">ನನ್ನ ಹಳೆಯ ದೂರುಗಳ ವಿವರಗಳು</p>
            </div>
            {{-- Summary Count Badge --}}
            <div id="countSummary" class="d-none">
                <span class="badge bg-highlight color-white px-3 py-2 rounded-s shadow-s">
                    <span id="totalCount">0</span> Records
                </span>
            </div>
        </div>

        {{-- Filter Form --}}
        <form id="filterForm" class="mb-4">
            <div class="row mb-0">
                <div class="col-6 text-start">
                    <label class="font-700 font-11 mb-1 color-highlight text-uppercase">From Date</label>
                    <input type="date" id="fromdate" class="form-control shadow-xs border-light-gray" 
                           style="border-radius:10px; font-size:12px; height:45px;">
                </div>

                <div class="col-6 text-start">
                    <label class="font-700 font-11 mb-1 color-highlight text-uppercase">To Date</label>
                    <input type="date" id="todate" class="form-control shadow-xs border-light-gray" 
                           style="border-radius:10px; font-size:12px; height:45px;">
                </div>
            </div>

            <button type="submit" class="btn btn-full mt-3 font-800 shadow-l text-uppercase"
                    style="background:#8cc152; height:45px; border-radius:10px;">
                <i class="fa fa-search me-2"></i> Generate Report
            </button>
        </form>

        <div class="table-responsive">
            <table class="table table-borderless text-center rounded-sm shadow-l" style="overflow: hidden;">
                <thead>
                    <tr class="bg-blue-dark">
                        <th class="py-3 font-11 text-white text-uppercase">#</th>
                        <th class="py-3 font-11 text-white text-uppercase">Ticket ID</th>
                        <th class="py-3 font-11 text-white text-uppercase text-start">Category</th>
                        <th class="py-3 font-11 text-white text-uppercase">Status</th>
                        <th class="py-3 font-11 text-white text-uppercase">View</th>
                    </tr>
                </thead>

                <tbody id="ticketData">
                    <tr>
                        <td colspan="5" class="py-5 opacity-50 font-12">
                            ವರದಿಗಳನ್ನು ನೋಡಲು ದಿನಾಂಕವನ್ನು ಆರಿಸಿ ಮತ್ತು 'Generate' ಕ್ಲಿಕ್ ಮಾಡಿ.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Print Action --}}
        <div class="text-center mt-4 d-none" id="printSection">
            <button onclick="window.print()" class="btn btn-xs bg-gray-dark color-white rounded-s">
                <i class="fa fa-print me-2"></i> Print Report
            </button>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Auto-fetch on load if you want current month data, or keep it empty
    fetchTickets();

    document.getElementById('filterForm').addEventListener('submit', e => {
        e.preventDefault();
        fetchTickets();
    });
});

async function fetchTickets() {
    const fromDate = document.getElementById('fromdate').value;
    const toDate   = document.getElementById('todate').value;
    const tbody    = document.getElementById('ticketData');
    const summary  = document.getElementById('countSummary');
    const printer  = document.getElementById('printSection');

    // Show Loading Spinner
    tbody.innerHTML = `
        <tr>
            <td colspan="5" class="py-5">
                <div class="spinner-border color-highlight" role="status"></div>
                <p class="font-11 mt-2 mb-0">ಮಾಹಿತಿ ಪಡೆಯಲಾಗುತ್ತಿದೆ...</p>
            </td>
        </tr>
    `;

    // Construct URL with Controller constraints
    let url = new URL("{{ route('public.complaints.report') }}");
    if (fromDate) url.searchParams.append('fromdate', fromDate);
    if (toDate)   url.searchParams.append('todate', toDate);

    try {
        const response = await fetch(url.toString(), {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();

        if (!result.data || result.data.length === 0) {
            summary.classList.add('d-none');
            printer.classList.add('d-none');
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="py-5">
                        <i class="fa fa-folder-open font-30 opacity-20 d-block mb-2"></i>
                        <span class="font-12 opacity-60">ಯಾವುದೇ ದೂರುಗಳು ಕಂಡುಬಂದಿಲ್ಲ (No records found)</span>
                    </td>
                </tr>
            `;
            return;
        }

        // Update UI with data
        tbody.innerHTML = '';
        document.getElementById('totalCount').innerText = result.data.length;
        summary.classList.remove('d-none');
        printer.classList.remove('d-none');

        // Map status/priority to Basavanagudi UI colors
        const colorMap = {
            resolved: 'bg-green-dark',
            pending: 'bg-red-dark',
            urgent: 'bg-red-dark',
            high: 'bg-warning color-black',
            medium: 'bg-blue-dark',
            low: 'bg-green-light',
            'in progress': 'bg-highlight'
        };

        result.data.forEach(ticket => {
            const statusKey = ticket.status.toLowerCase();
            const priorityKey = ticket.priority.toLowerCase();
            
            const statusClass = colorMap[statusKey] || (statusKey.includes('progress') ? colorMap['in progress'] : 'bg-secondary');
            
            tbody.innerHTML += `
                <tr class="border-bottom border-light-gray">
                    <td class="py-3 font-11 opacity-50">${ticket.sl_no}</td>
                    <td class="py-3 font-700 font-12 color-theme">${ticket.ticket_id}</td>
                    <td class="py-3 font-12 text-start color-theme">
                        ${ticket.category}
                        <span class="d-block font-10 opacity-50 mt-n1">${ticket.priority} Priority</span>
                    </td>
                    <td class="py-3">
                        <span class="badge ${statusClass} font-10 px-2 py-1" style="min-width:70px;">
                            ${ticket.status}
                        </span>
                    </td>
                    <td class="py-3 text-center">
                        <a href="${ticket.url}" class="icon icon-xs bg-highlight color-white rounded-s shadow-s">
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </td>
                </tr>
            `;
        });
    } catch (error) {
        tbody.innerHTML = `<tr><td colspan="5" class="py-4 text-danger">Error loading data. Please try again.</td></tr>`;
    }
}
</script>
@endpush