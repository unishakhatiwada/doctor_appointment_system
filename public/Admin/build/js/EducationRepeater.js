document.addEventListener('DOMContentLoaded', function () {
  // Get the initial education index from the Blade template or default to 1
  var educationRepeater = document.getElementById('educationRepeater');
  var educationIndex = parseInt(educationRepeater.getAttribute('data-education-index')) || 1;

  // Function to generate the education section HTML dynamically
  function generateEducationSection(index) {
    return `
            <div class="repeater-section">
                <div class="row">
                    <!-- Column 1 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="degree_${index}">Degree <i class="fas fa-university"></i> <span class="text-danger">*</span></label>
                            <select class="form-control" id="degree_${index}" name="education[${index}][degree]" required>
                                <option value="+2">+2</option>
                                <option value="bachelor">Bachelor</option>
                                <option value="master">Master</option>
                                <option value="phd">PhD</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="institute_name_${index}">Institute Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="institute_name_${index}" name="education[${index}][institute_name]" required>
                            <div class="invalid-feedback">Please fill the Institute Name</div>
                        </div>

                        <div class="form-group">
                            <label for="education_certificate_${index}">Certificate (PDF)</label>
                            <input type="file" class="form-control-file" id="education_certificate_${index}" name="education[${index}][certificate]" accept="application/pdf">
                        </div>

                        <div class="form-group">
                            <label for="education_additional_detail_${index}">Additional Details</label>
                            <textarea class="form-control" id="education_additional_detail_${index}" name="education[${index}][additional_detail]" rows="2"></textarea>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="institute_address_${index}">Institute Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="institute_address_${index}" name="education[${index}][institute_address]" required>
                            <div class="invalid-feedback">Please fill the Institute Address</div>
                        </div>

                        <div class="form-group">
                            <label for="faculty_${index}">Faculty <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="faculty_${index}" name="education[${index}][faculty]" required>
                            <div class="invalid-feedback">Please fill the Faculty</div>
                        </div>

                        <div class="form-group">
                            <label for="joining_date_bs_${index}">Joining Date (BS) <i class="fas fa-calendar-alt"></i> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control education-joining-date-bs" id="joining_date_bs_${index}" name="education[${index}][joining_date_bs]" required>
                            <!-- Hidden AD field for Joining Date -->
                            <input type="hidden" class="education-joining-date-ad" id="joining_date_ad_${index}" name="education[${index}][joining_date_ad]">
                            <div class="invalid-feedback">Please fill the valid Joining Date</div>
                        </div>

                        <div class="form-group">
                            <label for="graduation_date_bs_${index}">Graduation Date (BS) <i class="fas fa-calendar-alt"></i></label>
                            <input type="text" class="form-control education-graduation-date-bs" id="graduation_date_bs_${index}" name="education[${index}][graduation_date_bs]">
                            <!-- Hidden AD field for Graduation Date -->
                            <input type="hidden" class="education-graduation-date-ad" id="graduation_date_ad_${index}" name="education[${index}][graduation_date_ad]">
                        </div>

                        <div class="form-group">
                            <label for="grade_${index}">Grade (GPA) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="grade_${index}" name="education[${index}][grade]" required min="0" max="4" step="0.1">
                            <div class="invalid-feedback">Please fill the Grade</div>
                        </div>
                    </div>
                </div>

               <!-- Remove button for the repeater -->
<div class="d-flex justify-content-end">
    <button type="button" class="remove-education btn btn-danger" data-index="${index}">Remove Education</button>
    <input type="hidden" name="education[${index}][deleted]" class="deleted-input" value="0">
</div>
<hr />

            </div>
        `;
  }

  // Function to add a new education section dynamically
  function addEducationSection() {
    var newSection = document.createElement('div');
    newSection.innerHTML = generateEducationSection(educationIndex);

    // Append the new section to the repeater
    educationRepeater.appendChild(newSection);

    // Initialize the Nepali Date Pickers for the new section
    initializeNepaliDatePicker(`#joining_date_bs_${educationIndex}`, `#joining_date_ad_${educationIndex}`);
    initializeNepaliDatePicker(`#graduation_date_bs_${educationIndex}`, `#graduation_date_ad_${educationIndex}`);

    // Increment the index for the next section
    educationIndex++;
  }

  // Attach event listener to "Add More Education" button
  document.getElementById('addEducation').addEventListener('click', addEducationSection);

  // Event delegation for removing education sections and marking them as deleted
  educationRepeater.addEventListener('click', function(event) {
    if (event.target && event.target.classList.contains('remove-education')) {
      const section = event.target.closest('.repeater-section');
      // Mark the section as deleted by setting the value to 1
      section.querySelector('.deleted-input').value = '1';  // Update the hidden input value
      section.style.display = 'none';  // Hide the section visually

      console.log(section.querySelector('.deleted-input').value);  // Debug to ensure value is 1
    }
  });

  // Initialize Nepali Date Picker for existing sections (edit mode)
  initializeNepaliDatePicker('.education-joining-date-bs', '.education-joining-date-ad');
  initializeNepaliDatePicker('.education-graduation-date-bs', '.education-graduation-date-ad');
});
