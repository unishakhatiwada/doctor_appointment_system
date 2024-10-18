<div class="repeater-section">
    <div class="row">
        <!-- Column 1 -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="job_title">Job Title <i class="fas fa-id-badge"></i> {!! requiredField(true) !!}</label>
                <input type="text" class="form-control" name="experience[{{ $index }}][job_title]" value="{{ $experience->job_title ?? old('experience.'.$index.'.job_title') }}" required>
                <div class="invalid-feedback">Please fill Job Title field</div>
            </div>

            <div class="form-group">
                <label for="type_of_employment">Type of Employment <i class="fas fa-briefcase"></i> {!! requiredField(true) !!}</label>
                <select class="form-control" name="experience[{{ $index }}][type_of_employment]" required>
                    <option value="full_time" {{ (isset($experience) && $experience->type_of_employment == 'full_time') ? 'selected' : '' }}>Full-Time</option>
                    <option value="part_time" {{ (isset($experience) && $experience->type_of_employment == 'part_time') ? 'selected' : '' }}>Part-Time</option>
                    <option value="contract" {{ (isset($experience) && $experience->type_of_employment == 'contract') ? 'selected' : '' }}>Contract</option>
                    <option value="internship" {{ (isset($experience) && $experience->type_of_employment == 'internship') ? 'selected' : '' }}>Internship</option>
                </select>
                <div class="invalid-feedback">Please select Type of Employment</div>
            </div>

            <div class="form-group">
                <label for="health_care_name">Healthcare Name {!! requiredField(true) !!}</label>
                <input type="text" class="form-control" name="experience[{{ $index }}][health_care_name]" value="{{ $experience->health_care_name ?? old('experience.'.$index.'.health_care_name') }}" required>
                <div class="invalid-feedback">Please fill Healthcare Name field</div>
            </div>
        </div>

        <!-- Column 2 -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="health_care_location">Healthcare Location {!! requiredField(true) !!}</label>
                <input type="text" class="form-control" name="experience[{{ $index }}][health_care_location]" value="{{ $experience->health_care_location ?? old('experience.'.$index.'.health_care_location') }}" required>
                <div class="invalid-feedback">Please fill Healthcare Location field</div>
            </div>

            <div class="form-group">
                <label for="experience_start_date_bs">Start Date (BS) {!! requiredField(true) !!} <i class="fas fa-calendar-alt"></i></label>
                <input type="text" class="form-control experience-start-date-bs" name="experience[{{ $index }}][start_date_bs]" value="{{ $experience->start_date_bs ?? old('experience.'.$index.'.start_date_bs') }}" required>
                <!-- Hidden AD date -->
                <input type="hidden" class="experience-start-date-ad" name="experience[{{ $index }}][start_date_ad]" value="{{ $experience->start_date_ad ?? old('experience.'.$index.'.start_date_ad') }}">
                <div class="invalid-feedback">Please fill Start Date field</div>
            </div>

            <div class="form-group">
                <label for="experience_end_date_bs">End Date (BS) <i class="fas fa-calendar-alt"></i></label>
                <input type="text" class="form-control experience-end-date-bs" name="experience[{{ $index }}][end_date_bs]" value="{{ $experience->end_date_bs ?? old('experience.'.$index.'.end_date_bs') }}">
                <!-- Hidden AD date -->
                <input type="hidden" class="experience-end-date-ad" name="experience[{{ $index }}][end_date_ad]" value="{{ $experience->end_date_ad ?? old('experience.'.$index.'.end_date_ad') }}">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="experience_additional_detail">Additional Details</label>
        <textarea class="form-control" name="experience[{{ $index }}][additional_detail]" rows="2">{{ $experience->additional_detail ?? old('experience.'.$index.'.additional_detail') }}</textarea>
    </div>

    <div class="form-group">
        <label for="experience_certificate">Certificate (PDF)</label>
        <input type="file" class="form-control-file" name="experience[{{ $index }}][certificate]" accept="application/pdf">
    </div>

    <!-- Remove button for the repeater -->
    <div class="d-flex justify-content-end">
        <button type="button" class="remove-experience btn btn-danger">Remove Experience</button>
    </div>
    <hr />
</div>