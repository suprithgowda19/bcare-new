@extends('layouts.staff')

@section('content')
<div class="page-content" style="min-height:60vh!important">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="ms-3 me-3 mb-3 alert alert-small rounded-s shadow-xl bg-green-dark text-white">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="ms-3 me-3 mb-3 alert alert-small rounded-s shadow-xl bg-red-dark text-white">
            {{ session('error') }}
        </div>
    @endif

    {{-- Complaint Details --}}
    <div class="card card-style ms-3 me-3 mb-3">
        <div class="content">

            <h5 class="mb-3">Complaint Details</h5>

            <table class="table table-borderless">
                <tr>
                    <th>Ticket ID</th>
                    <td>SP-{{ $complaint->id }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $complaint->category->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Sub Category</th>
                    <td>{{ $complaint->subCategory->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Ward</th>
                    <td>{{ $complaint->ward->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Priority</th>
                    <td>{{ ucfirst($complaint->priority) }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst(str_replace('-', ' ', $complaint->status)) }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $complaint->description ?? '-' }}</td>
                </tr>
            </table>

        </div>
    </div>

    {{-- Update Status Section --}}
    <div id="status-update"></div>

    @can('updateStatus', $complaint)
        @if($complaint->status !== 'resolved')
            <div class="card card-style ms-3 me-3 mb-3">
                <div class="content">
                    <h5 class="mb-3">Update Complaint Status</h5>

                    <form method="POST"
                          action="{{ route('staff.complaints.status', $complaint->id) }}"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">-- Select Status --</option>
                                <option value="pending">Pending</option>
                                <option value="in-progress">In Progress</option>
                                <option value="resolved">Resolved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks"
                                      class="form-control"
                                      rows="3"
                                      required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Images (Max 2)</label>
                            <input type="file"
                                   name="images[]"
                                   class="form-control"
                                   accept="image/*"
                                   multiple>
                        </div>

                        <button type="submit"
                                class="btn btn-sm"
                                style="background:#e45b44; color:white;">
                            Update Status
                        </button>
                    </form>

                </div>
            </div>
        @endif
    @endcan

    {{-- Update History --}}
    <div class="card card-style ms-3 me-3 mb-5">
        <div class="content">
            <h5 class="mb-3">Update History</h5>

            @forelse($complaint->updates as $update)
                <div class="border-bottom mb-2 pb-2">
                    <small class="opacity-70">
                        {{ $update->created_at->format('d M Y, h:i A') }}
                        by {{ $update->staff->name ?? 'System' }}
                    </small>
                    <p class="mb-1">
                        <strong>Status:</strong>
                        {{ ucfirst(str_replace('-', ' ', $update->status)) }}
                    </p>
                    <p class="mb-1">{{ $update->remarks }}</p>

                    @if(!empty($update->images))
                        <div class="mt-2">
                            @foreach($update->images as $img)
                                <a href="{{ asset('storage/'.$img) }}" target="_blank">
                                    <img src="{{ asset('storage/'.$img) }}"
                                         width="60"
                                         class="me-1 mb-1 rounded">
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <p class="opacity-50">No updates available.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
