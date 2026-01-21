@extends('layouts.staff')

@section('content')
<div class="page-content" style="min-height:60vh!important">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="ms-3 me-3 mb-3 alert alert-small rounded-s shadow-xl bg-green-dark text-white">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="ms-3 me-3 mb-3 alert alert-small rounded-s shadow-xl bg-red-dark text-white">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Complaint Update Card --}}
    <div class="card card-style ms-3 me-3 mb-4">
        <div class="content">

            <h5 class="mb-3">Update Complaint Details</h5>

            <form method="POST"
                  action="{{ route('staff.complaints.update', $complaint->id) }}">
                @csrf
                @method('PUT')

                {{-- Ticket ID --}}
                <div class="mb-3">
                    <label class="form-label">Ticket ID</label>
                    <input type="text"
                           class="form-control"
                           value="SP-{{ $complaint->id }}"
                           disabled>
                </div>

                {{-- Category --}}
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id"
                            class="form-control"
                            required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $complaint->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sub Category --}}
                <div class="mb-3">
                    <label class="form-label">Sub Category</label>
                    <select name="sub_category_id"
                            class="form-control">
                        <option value="">-- Select Sub Category --</option>
                        @foreach($subCategories as $sub)
                            <option value="{{ $sub->id }}"
                                {{ $complaint->sub_category_id == $sub->id ? 'selected' : '' }}>
                                {{ $sub->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Priority --}}
                <div class="mb-3">
                    <label class="form-label">Priority</label>
                    <select name="priority"
                            class="form-control"
                            required>
                        <option value="">-- Select Priority --</option>
                        <option value="low" {{ $complaint->priority === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ $complaint->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ $complaint->priority === 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ $complaint->priority === 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status"
                            class="form-control"
                            required>
                        <option value="">-- Select Status --</option>
                        <option value="pending" {{ $complaint->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in-progress" {{ $complaint->status === 'in-progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ $complaint->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="rejected" {{ $complaint->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                {{-- Submit --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('staff.dashboard') }}"
                       class="btn btn-sm"
                       style="background:#6c757d; color:white;">
                        Back
                    </a>

                    <button type="submit"
                            class="btn btn-sm"
                            style="background:#e45b44; color:white;">
                        Update Complaint
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
