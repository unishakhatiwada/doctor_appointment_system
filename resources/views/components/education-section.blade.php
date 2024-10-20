<div class="repeater-section">
    <input type="hidden" name="education[{{ $index }}][id]" value="{{ $education->id ?? '' }}">
    <input type="hidden" class="delete-education" name="education[{{ $index }}][deleted]" value="0"> <!-- Hidden delete flag -->

    <div class="row">
        <!-- Column 1 -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="degree_{{ $index }}">Degree <i class="fas fa-university"></i> {!! requiredField(true) !!}</label>
                <select class="form-control" id="degree_{{ $index }}" name="education[{{ $index }}][degree]" required>
                    <option value="+2" {{ old('education.'.$index.'.degree', $education->degree ?? '') == '+2' ? 'selected' : '' }}>+2</option>
                    <option value="bachelor" {{ old('education.'.$index.'.degree', $education->degree ?? '') == 'bachelor' ? 'selected' : '' }}>Bachelor</option>
                    <option value="master" {{ old('education.'.$index.'.degree', $education->degree ?? '') == 'master' ? 'selected' : '' }}>Master</option>
                    <option value="phd" {{ old('education.'.$index.'.degree', $education->degree ?? '') == 'phd' ? 'selected' : '' }}>PhD</option>
                </select>
            </div>

            <div class="form-group">
                <label for="institute_name_{{ $index }}">Institute Name {!! requiredField(true) !!}</label>
                <input type="text" class="form-control" id="institute_name_{{ $index }}" name="education[{{ $index }}][institute_name]" value="{{ old('education.'.$index.'.institute_name', $education->institute_name ?? '') }}" required>
                <div class="invalid-feedback">Please fill the Institute Name</div>
            </div>

            <div class="form-group">
                <label for="education_certificate_{{ $index }}">Education Certificate (PDF)</label>
                <!-- Input field for uploading a new certificate -->
                <input type="file" class="form-control-file" name="education[{{ $index }}][certificate]" accept="application/pdf">

                <!-- Display existing certificate link and delete option if the certificate exists -->
                @if(isset($education['certificate']) && $education['certificate'])
                    <div class="mt-2">
                        <a href="{{ asset($education['certificate']) }}" target="_blank">View Current Education Certificate</a>
                        <label class="ml-3">
                            <input type="checkbox" name="education[{{ $index }}][delete_certificate]" value="1"> Delete Current Certificate
                        </label>
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="education_additional_detail_{{ $index }}">Additional Details</label>
                <textarea class="form-control" id="education_additional_detail_{{ $index }}" name="education[{{ $index }}][additional_detail]" rows="2">{{ old('education.'.$index.'.additional_detail', $education->additional_detail ?? '') }}</textarea>
            </div>
        </div>

        <!-- Column 2 -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="institute_address_{{ $index }}">Institute Address {!! requiredField(true) !!}</label>
                <input type="text" class="form-control" id="institute_address_{{ $index }}" name="education[{{ $index }}][institute_address]" value="{{ old('education.'.$index.'.institute_address', $education->institute_address ?? '') }}" required>
                <div class="invalid-feedback">Please fill the Institute Address</div>
            </div>

            <div class="form-group">
                <label for="faculty_{{ $index }}">Faculty {!! requiredField(true) !!}</label>
                <input type="text" class="form-control" id="faculty_{{ $index }}" name="education[{{ $index }}][faculty]" value="{{ old('education.'.$index.'.faculty', $education->faculty ?? '') }}" required>
                <div class="invalid-feedback">Please fill the Faculty Name</div>
            </div>

            <div class="form-group">
                <label for="joining_date_bs_{{ $index }}">Joining Date (BS) <i class="fas fa-calendar-alt"></i> {!! requiredField(true) !!}</label>
                <input type="text" class="form-control education-joining-date-bs" id="joining_date_bs_{{ $index }}" name="education[{{ $index }}][joining_date_bs]" value="{{ old('education.'.$index.'.joining_date_bs', $education->joining_date_bs ?? '') }}" required>
                <!-- Hidden AD field for Joining Date -->
                <input type="hidden" class="education-joining-date-ad" id="joining_date_ad_{{ $index }}" name="education[{{ $index }}][joining_date_ad]" value="{{ old('education.'.$index.'.joining_date_ad', $education->joining_date_ad ?? '') }}">
                <div class="invalid-feedback">Please fill the valid Joining Date</div>
            </div>

            <div class="form-group">
                <label for="graduation_date_bs_{{ $index }}">Graduation Date (BS) <i class="fas fa-calendar-alt"></i></label>
                <input type="text" class="form-control education-graduation-date-bs" id="graduation_date_bs_{{ $index }}" name="education[{{ $index }}][graduation_date_bs]" value="{{ old('education.'.$index.'.graduation_date_bs', $education->graduation_date_bs ?? '') }}">
                <!-- Hidden AD field for Graduation Date -->
                <input type="hidden" class="education-graduation-date-ad" id="graduation_date_ad_{{ $index }}" name="education[{{ $index }}][graduation_date_ad]" value="{{ old('education.'.$index.'.graduation_date_ad', $education->graduation_date_ad ?? '') }}">
            </div>

            <div class="form-group">
                <label for="grade_{{ $index }}">Grade (GPA) {!! requiredField(true) !!}</label>
                <input type="number" class="form-control" id="grade_{{ $index }}" name="education[{{ $index }}][grade]" value="{{ old('education.'.$index.'.grade', $education->grade ?? '') }}" required min="0" max="4" step="0.1">
                <div class="invalid-feedback">Please fill the Grade Field</div>
            </div>
        </div>
    </div>

    <!-- Remove button for the repeater -->
    <div class="d-flex justify-content-end">
        <button type="button" class="remove-education btn btn-danger" data-index="{{ $index }}">Remove Education</button>
        <input type="hidden" name="education[{{ $index }}][deleted]" class="deleted-input" value="0">
    </div>
    <hr />
</div>
