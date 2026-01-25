@extends('layouts.staff')

@section('content')
<div class="page-content" style="min-height:60vh!important">

    {{-- 1. SLA & Deadline Header --}}
    @if($complaint->due_at)
        <div class="card card-style ms-3 me-3 mb-3 {{ $complaint->due_at->isPast() ? 'bg-red-dark' : 'bg-blue-dark' }}">
            <div class="content mb-0 mt-3">
                <div class="d-flex">
                    <div class="align-self-center">
                        <h1 class="color-white mb-0"><i class="fa {{ $complaint->due_at->isPast() ? 'fa-exclamation-triangle' : 'fa-clock' }} font-20"></i></h1>
                    </div>
                    <div class="align-self-center ms-3">
                        <h5 class="color-white font-700 mb-0">
                            {{ $complaint->due_at->isPast() ? 'SLA Breached' : 'SLA Deadline' }}
                        </h5>
                        <p class="color-white opacity-60 mb-3 font-11">
                            Target Resolution: {{ $complaint->due_at->format('d M, Y - h:i A') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Railroad Progress Indicator --}}
    <div class="card card-style ms-3 me-3 mb-3">
        <div class="content">
            @php 
                $currentStepNumber = $complaint->currentStep->step_number ?? 1;
                $currentDesignation = $complaint->currentStep->designation->name ?? 'Initial Review';
                $totalSteps = $complaint->workflow->steps->count() ?: 1;
                $progress = ($currentStepNumber / $totalSteps) * 100;
            @endphp

            <div class="d-flex justify-content-between align-items-center mb-0">
                <div>
                    <p class="mb-n1 font-10 font-700 text-uppercase color-highlight">Active Station</p>
                    <h4 class="font-700">{{ $currentDesignation }}</h4>
                </div>
                <div class="text-end">
                    <span class="badge bg-fade-blue-dark color-blue-dark p-2">
                        Level {{ $currentStepNumber }} of {{ $totalSteps }}
                    </span>
                </div>
            </div>
            <div class="progress mt-3" style="height:8px;">
                <div class="progress-bar bg-highlight" style="width: {{ $progress }}%"></div>
            </div>
            <p class="font-10 text-center mt-2 opacity-50">
                <strong>Department:</strong> {{ $complaint->category->name }} | <strong>Track:</strong> {{ $complaint->workflow->name }}
            </p>
        </div>
    </div>

    {{-- Error Handling --}}
    @if($errors->any())
        <div class="ms-3 me-3 mb-3 alert alert-small rounded-s shadow-xl bg-red-dark text-white">
            <ul class="mb-0">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    {{-- Evidence Submission Form --}}
    <div class="card card-style ms-3 me-3 mb-4">
        <div class="content">
            <h5 class="mb-3 font-700">Submit Progress Evidence</h5>
            
            {{-- Updated Action to match your controller's 'push' method --}}
            <form method="POST" action="{{ route('staff.complaints.push', $complaint->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="input-style has-borders no-icon mb-4">
                    <label for="remarks" class="color-highlight font-11 font-700">Action Remarks & Site Notes</label>
                    <textarea id="remarks" name="remarks" class="form-control" 
                              placeholder="Describe the actions taken at this stage..." 
                              style="height:100px;" required></textarea>
                    <em class="font-10">(Minimum 10 characters required for audit trail)</em>
                </div>

                <div class="mb-4">
                    <label class="font-11 font-700 color-highlight mb-2 d-block text-uppercase">Photo Evidence (Max 5)</label>
                    <div class="file-data">
                        <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                    </div>
                    <p class="font-10 opacity-50 mt-1">Upload JPG/PNG. Max 5MB per file.</p>
                </div>

                <div class="divider mt-4 mb-4"></div>

                <div class="row mb-0">
                    <div class="col-12">
                        @php
                            $nextStep = $complaint->workflow->steps
                                ->where('step_number', '>', $currentStepNumber)
                                ->sortBy('step_number')
                                ->first();
                        @endphp

                        @if($nextStep)
                            <div class="bg-fade-blue-light p-3 rounded-s mb-4 border border-blue-dark">
                                <p class="color-blue-dark mb-0 font-12">
                                    <i class="fa fa-arrow-up me-2"></i>
                                    <strong>Escalation Path:</strong> This will be moved to <strong>{{ $nextStep->designation->name }}</strong> for the next phase.
                                </p>
                            </div>
                            <button type="submit" class="btn btn-full btn-m rounded-s font-700 shadow-l bg-blue-dark w-100">
                                Verify & Push to Stage {{ $nextStep->step_number }}
                            </button>
                        @else
                            <div class="bg-fade-green-light p-3 rounded-s mb-4 border border-green-dark">
                                <p class="color-green-dark mb-0 font-12">
                                    <i class="fa fa-check-double me-2"></i>
                                    <strong>Final Station:</strong> You are the last authority. Submitting will mark this complaint as <strong>Resolved</strong>.
                                </p>
                            </div>
                            <button type="submit" class="btn btn-full btn-m rounded-s font-700 shadow-l bg-green-dark w-100">
                                Finalize & Resolve Ticket
                            </button>
                        @endif
                        
                        <a href="{{ route('staff.dashboard') }}" class="btn btn-full btn-m font-700 color-theme opacity-50 mt-2">
                            Cancel & Return to Dashboard
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection