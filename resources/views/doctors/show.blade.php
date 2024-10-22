@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4 d-flex justify-content-center">
        <div class="col-md-10">
            <!-- Tab Navigation -->
            <ul class="nav nav-tabs" id="doctorDetailsTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="doctor-info-tab" data-toggle="tab" href="#doctor-info" role="tab" aria-controls="doctor-info" aria-selected="true">
                        Doctor Information
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="education-info-tab" data-toggle="tab" href="#education-info" role="tab" aria-controls="education-info" aria-selected="false">
                        Education Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="experience-info-tab" data-toggle="tab" href="#experience-info" role="tab" aria-controls="experience-info" aria-selected="false">
                        Experience Details
                    </a>
                </li>
            </ul>

            <div class="tab-content mt-3" id="doctorDetailsTabContent">
                <!-- Doctor Information Tab -->
                <div class="tab-pane fade show active" id="doctor-info" role="tabpanel" aria-labelledby="doctor-info-tab">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4>Doctor Information</h4>
                        </div>
                        <div class="card-body row">
                            <!-- Left Column: Doctor Information -->
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item"><strong>Name:</strong> {{ $doctor->name }}</li>
                                    <li class="list-group-item"><strong>Email:</strong> {{ $doctor->email }}</li>
                                    <li class="list-group-item"><strong>Phone:</strong> {{ $doctor->phone }}</li>
                                    <li class="list-group-item"><strong>Gender:</strong> {{ ucfirst($doctor->gender) }}</li>
                                    <li class="list-group-item"><strong>Marital Status:</strong> {{ ucfirst($doctor->marital_status) }}</li>
                                    <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($doctor->status) }}</li>
                                    <li class="list-group-item"><strong>Date of Birth (BS):</strong> {{ $doctor->date_of_birth_bs ?? 'N/A' }}</li>
                                    <li class="list-group-item"><strong>Department:</strong> {{ $doctor->department->name ?? 'N/A' }}</li>

                                </ul>
                            </div>

                            <!-- Right Column: Address Information -->
                            <div class="col-md-6">
                                <!-- Permanent Address -->
                                <div class="card mb-4">
                                    <div class="card-header bg-purple text-white">
                                        <h7>Permanent Address</h7>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>Province:</strong> {{ $permanentProvince->nepali_name ?? 'N/A' }}</li>
                                        <li class="list-group-item"><strong>District:</strong> {{ $permanentDistrict->district_nepali_name ?? 'N/A' }}</li>
                                        <li class="list-group-item"><strong>Municipality:</strong> {{ $permanentMunicipality->muni_name ?? 'N/A' }}</li>
                                    </ul>
                                </div>

                                <!-- Temporary Address -->
                                <div class="card mb-4">
                                    <div class="card-header bg-purple text-white">
                                        <h7>Temporary Address</h7>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>Province:</strong> {{ $temporaryProvince->nepali_name ?? 'N/A' }}</li>
                                        <li class="list-group-item"><strong>District:</strong> {{ $temporaryDistrict->district_nepali_name ?? 'N/A' }}</li>
                                        <li class="list-group-item"><strong>Municipality:</strong> {{ $temporaryMunicipality->muni_name ?? 'N/A' }}</li>
                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Education Details Tab -->
                <div class="tab-pane fade" id="education-info" role="tabpanel" aria-labelledby="education-info-tab">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4>Education Details</h4>
                        </div>
                        <div class="card-body">
                            @if($doctor->educations->isNotEmpty())
                                <div class="list-group">
                                    @foreach($doctor->educations as $index => $education)
                                        <div class="list-group-item mb-3">
                                            <h5><strong>Education #{{ $index + 1 }}</strong></h5>
                                            <p><strong>Degree:</strong> {{ $education->degree }}</p>
                                            <p><strong>Institute Name:</strong> {{ $education->institute_name }}</p>
                                            <p><strong>Institute Address:</strong> {{ $education->institute_address }}</p>
                                            <p><strong>Faculty:</strong> {{ $education->faculty }}</p>
                                            <p><strong>Grade:</strong> {{ $education->grade }}</p>
                                            <p><strong>Duration:</strong> {{ $education->joining_date }} to {{ $education->graduation_date }}</p>
                                            <p><strong>Additional Details:</strong> {{ $education->additional_detail }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p>No education records available.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Experience Details Tab -->
                <div class="tab-pane fade" id="experience-info" role="tabpanel" aria-labelledby="experience-info-tab">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4>Experience Details</h4>
                        </div>
                        <div class="card-body">
                            @if($doctor->experiences->isNotEmpty())
                                <div class="list-group">
                                    @foreach($doctor->experiences as $index => $experience)
                                        <div class="list-group-item mb-3">
                                            <h5><strong>Experience #{{ $index + 1 }}</strong></h5>
                                            <p><strong>Job Title:</strong> {{ $experience->job_title }}</p>
                                            <p><strong>Type of Employment:</strong> {{ ucfirst($experience->type_of_employment) }}</p>
                                            <p><strong>Healthcare Name:</strong> {{ $experience->health_care_name }}</p>
                                            <p><strong>Healthcare Location:</strong> {{ $experience->health_care_location }}</p>
                                            <p><strong>Duration:</strong> {{ $experience->start_date }} to {{ $experience->end_date ?? 'Present' }}</p>
                                            <p><strong>Additional Details:</strong> {{ $experience->additional_detail }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p>No experience records available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-start mt-4">
                <a href="{{ route('doctors.index') }}" class="btn btn-secondary mr-2">Back to List</a>
                <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-primary">Edit Doctor</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Include Bootstrap JS for Tabs -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush
