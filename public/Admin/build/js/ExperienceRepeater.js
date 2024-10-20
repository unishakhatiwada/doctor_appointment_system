document.addEventListener('DOMContentLoaded', function () {
  var experienceRepeater = document.getElementById('experienceRepeater');
  var experienceIndex = parseInt(experienceRepeater.getAttribute('data-experience-index')) || 1;

  // Function to generate the experience section HTML dynamically
  function generateExperienceSection(index) {
    return `
            <div class="repeater-section">
                <div class="row">
                    <!-- Column 1 -->
                    <div class="col-md-6">
                        <!-- Job Title -->
                        <div class="form-group">
                            <label for="job_title_${index}">Job Title <i class="fas fa-id-badge"></i> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="job_title_${index}" name="experience[${index}][job_title]" required>
                            <div class="invalid-feedback">Please fill Job Title field</div>
                        </div>

                        <!-- Type of Employment -->
                        <div class="form-group">
                            <label for="type_of_employment_${index}">Type of Employment <i class="fas fa-briefcase"></i> <span class="text-danger">*</span></label>
                            <select class="form-control" id="type_of_employment_${index}" name="experience[${index}][type_of_employment]" required>
                                <option value="full_time">Full-Time</option>
                                <option value="part_time">Part-Time</option>
                                <option value="contract">Contract</option>
                                <option value="internship">Internship</option>
                            </select>
                            <div class="invalid-feedback">Please select Type of Employment</div>
                        </div>

                        <!-- Healthcare Name -->
                        <div class="form-group">
                            <label for="health_care_name_${index}">Healthcare Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="health_care_name_${index}" name="experience[${index}][health_care_name]" required>
                            <div class="invalid-feedback">Please fill Healthcare Name field</div>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="col-md-6">
                        <!-- Healthcare Location -->
                        <div class="form-group">
                            <label for="health_care_location_${index}">Healthcare Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="health_care_location_${index}" name="experience[${index}][health_care_location]" required>
                            <div class="invalid-feedback">Please fill Healthcare Location field</div>
                        </div>

                        <!-- Start Date (BS) and hidden AD field -->
                        <div class="form-group">
                            <label for="experience_start_date_bs_${index}">Start Date (BS) <i class="fas fa-calendar-alt"></i> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control experience-start-date-bs" id="experience_start_date_bs_${index}" name="experience[${index}][start_date_bs]" required>
                            <input type="hidden" class="experience-start-date-ad" id="experience_start_date_ad_${index}" name="experience[${index}][start_date_ad]">
                            <div class="invalid-feedback">Please fill Start Date field</div>
                        </div>

                        <!-- End Date (BS) and hidden AD field -->
                        <div class="form-group">
                            <label for="experience_end_date_bs_${index}">End Date (BS) <i class="fas fa-calendar-alt"></i></label>
                            <input type="text" class="form-control experience-end-date-bs" id="experience_end_date_bs_${index}" name="experience[${index}][end_date_bs]">
                            <input type="hidden" class="experience-end-date-ad" id="experience_end_date_ad_${index}" name="experience[${index}][end_date_ad]">
                        </div>
                    </div>
                </div>

                <!-- Additional Details -->
                <div class="form-group">
                    <label for="experience_additional_detail_${index}">Additional Details</label>
                    <textarea class="form-control" id="experience_additional_detail_${index}" name="experience[${index}][additional_detail]" rows="2"></textarea>
                </div>

                <!-- Certificate (PDF) -->
                <div class="form-group">
                    <label for="experience_certificate_${index}">Certificate (PDF)</label>
                    <input type="file" class="form-control-file" id="experience_certificate_${index}" name="experience[${index}][certificate]" accept="application/pdf">
                </div>

                <!-- Remove button for the repeater -->
                <div class="d-flex justify-content-end">
                    <button type="button" class="remove-experience btn btn-danger">Remove Experience</button>
                </div>
                <hr />
            </div>
        `;
  }

  // Function to add a new experience section dynamically
  function addExperienceSection() {
    var newSection = document.createElement('div');
    newSection.innerHTML = generateExperienceSection(experienceIndex);

    // Append the new section to the repeater
    experienceRepeater.appendChild(newSection);

    // Initialize the Nepali Date Pickers for the new section
    initializeNepaliDatePicker(`#experience_start_date_bs_${experienceIndex}`, `#experience_start_date_ad_${experienceIndex}`);
    initializeNepaliDatePicker(`#experience_end_date_bs_${experienceIndex}`, `#experience_end_date_ad_${experienceIndex}`);

    // Increment the index for the next section
    experienceIndex++;
  }

  // Attach event listener to "Add More Experience" button
  document.getElementById('addExperience').addEventListener('click', addExperienceSection);

  // Event delegation for removing experience sections
  experienceRepeater.addEventListener('click', function(event) {
    if (event.target && event.target.classList.contains('remove-experience')) {
      const section = event.target.closest('.repeater-section');
      section.style.display = 'none';  // Hide the section visually
      section.querySelector('.deleted-input').value = 1;  // Mark the hidden input for deletion
    }
  });

  // Initialize Nepali Date Picker for existing sections (edit mode)
  initializeNepaliDatePicker('.experience-start-date-bs', '.experience-start-date-ad');
  initializeNepaliDatePicker('.experience-end-date-bs', '.experience-end-date-ad');
});
