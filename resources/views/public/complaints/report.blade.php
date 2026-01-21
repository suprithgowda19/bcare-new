@extends('layouts.public')

@section('title', 'ವರದಿ - Reports')

{{-- ✅ Page-specific navbar title --}}
@section('nav_title')
    ವರದಿ
@endsection

@section('content')

<div class="card card-style mt-n5">
    <div class="content pt-2">
        <h4 class="font-700 text-start">ದೂರುಗಳ ವರದಿ</h4>
        <p class="font-11 mt-n2 mb-3 text-start">
            Filter and view your historical complaints
        </p>

        {{-- Filter Form --}}
        <form id="filterForm" class="mb-4">
            <div class="row mb-0">
                <div class="col-6 text-start">
                    <label class="font-600 color-theme font-11">From Date</label>
                    <input type="date"
                           name="fromdate"
                           class="form-control shadow-xs"
                           id="fromdate"
                           style="border-radius:8px;font-size:12px;">
                </div>
                <div class="col-6 text-start">
                    <label class="font-600 color-theme font-11">To Date</label>
                    <input type="date"
                           name="todate"
                           class="form-control shadow-xs"
                           id="todate"
                           style="border-radius:8px;font-size:12px;">
                </div>
            </div>

            <button type="submit"
                    class="btn btn-sm btn-secondary w-100 mt-3 font-700 shadow-l"
                    id="filterBtn"
                    style="background:#8cc152 !important;height:40px;border-radius:8px;">
                <i class="fa fa-filter me-2"></i>Filter
            </button>
        </form>

        <div class="table-responsive">
            <table class="table table-borderless text-center rounded-sm shadow-l"
                   style="overflow:hidden;min-width:450px;">
                <thead>
                    <tr style="background:#e45b44 !important">
                        <th scope="col" class="py-3 font-13 text-white">#</th>
                        <th scope="col" class="py-3 font-13 text-white">Ticket Id</th>
                        <th scope="col" class="py-3 font-13 text-white text-start">Category</th>
                        <th scope="col" class="py-3 font-13 text-white">Status</th>
                        <th scope="col" class="py-3 font-13 text-white">Action</th>
                    </tr>
                </thead>
                <tbody id="ticketData">
                    <tr>
                        <td colspan="5" class="py-5 opacity-50 font-12">
                            ವರದಿಗಳನ್ನು ನೋಡಲು ದಿನಾಂಕವನ್ನು ಆರಿಸಿ
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('filterForm');
    fetchTickets();

    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        fetchTickets();
    });
});

async function fetchTickets() {
    const fromDate = document.getElementById('fromdate').value;
    const toDate   = document.getElementById('todate').value;
    const tableBody = document.getElementById('ticketData');

    tableBody.innerHTML =
        '<tr><td colspan="5" class="py-5">' +
        '<div class="spinner-border color-highlight" role="status"></div>' +
        '</td></tr>';

    try {
        let url = new URL("{{ route('complaints.report') }}", window.location.origin);
        if (fromDate) url.searchParams.append('fromdate', fromDate);
        if (toDate)   url.searchParams.append('todate', toDate);

        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const result = await response.json();
        let rows = '';

        if (!result.data || result.data.length === 0) {
            rows = '<tr><td colspan="5" class="py-4">ಯಾವುದೇ ದಾಖಲೆಗಳು ಕಂಡುಬಂದಿಲ್ಲ.</td></tr>';
        } else {
            result.data.forEach(ticket => {
                let badgeColor = 'bg-highlight';
                const status = ticket.status.toLowerCase();

                if (status.includes('resolved')) badgeColor = 'bg-green-dark';
                if (status.includes('pending'))  badgeColor = 'bg-red-dark';
                if (status.includes('progress')) badgeColor = 'bg-blue-dark';

                rows += `
                    <tr class="border-bottom">
                        <td class="py-3 font-12">${ticket.sl_no}</td>
                        <td class="py-3 font-700 font-12 color-theme">${ticket.ticket_id}</td>
                        <td class="py-3 font-12 text-start">${ticket.category}</td>
                        <td class="py-3">
                            <span class="badge ${badgeColor} font-9 px-2 py-1 text-uppercase">
                                ${ticket.status}
                            </span>
                        </td>
                        <td class="py-3">
                            <a href="${ticket.url}"
                               class="icon icon-xs bg-highlight color-white rounded-s shadow-s">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>`;
            });
        }

        tableBody.innerHTML = rows;

    } catch (error) {
        tableBody.innerHTML =
            '<tr><td colspan="5" class="text-danger py-5">' +
            'Error loading report.' +
            '</td></tr>';
    }
}
</script>
@endpush
