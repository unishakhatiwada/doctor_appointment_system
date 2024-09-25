document.addEventListener('DOMContentLoaded', function () {
  var educationIndex = 1;

  // Function to add new education entry
  document.getElementById('addEducation').addEventListener('click', function () {
    var repeater = document.getElementById('educationRepeater');
    var newSection = document.createElement('div');
    newSection.classList.add('repeater-section');
    newSection.innerHTML = `
            <div class="row">
                <!-- Column 1 -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="degree">Degree <i class="fas fa-university"></i></label>
                        <select class="form-control" name="education[${educationIndex}][degree]" required>
                            <option value="+2">+2</option>
                            <option value="bachelor">Bachelor</option>
                            <option value="master">Master</option>
                            <option value="phd">PhD</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="college_name">College Name</label>
                        <input type="text" class="form-control" name="education[${educationIndex}][college_name]" required>
                        <div class="invalid-feedback">Please fill the College Name</div>
                    </div>

                    <div class="form-group">
                        <label for="education_certificate">Certificate (PDF)</label>
                        <input type="file" class="form-control-file" name="education[${educationIndex}][certificate]" accept="application/pdf">
                    </div>

                    <div class="form-group">
                        <label for="education_additional_detail">Additional Details</label>
                      <textarea class="form-control" name="education[${educationIndex}][additional_detail]" rows="2"></textarea>
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="college_address">College Address</label>
                        <input type="text" class="form-control" name="education[${educationIndex}][college_address]" required>
                        <div class="invalid-feedback">Please fill the College Address</div>
                    </div>

                    <div class="form-group">
                        <label for="faculty">Faculty</label>
                        <input type="text" class="form-control" name="education[${educationIndex}][faculty]" required>
                        <div class="invalid-feedback">Please fill the Faculty</div>
                    </div>

                    <div class="form-group">
                        <label for="education_start_date">Start Date <i class="fas fa-calendar-alt"></i></label>
                        <input type="date" class="form-control" name="education[${educationIndex}][start_date]" required>
                        <div class="invalid-feedback">Please fill the College Start Date</div>
                    </div>

                    <div class="form-group">
                        <label for="education_end_date">End Date <i class="fas fa-calendar-alt"></i></label>
                        <input type="date" class="form-control" name="education[${educationIndex}][end_date]" required>
                        <div class="invalid-feedback">Please fill the College End Date</div>
                    </div>
                </div>
            </div>

            <!-- Remove button for the repeater -->
            <div class="d-flex justify-content-end">
              <button type="button" class="remove-education btn btn-danger">Remove Education</button>
            </div>

            <hr />`;

    // Append new section
    repeater.appendChild(newSection);

    // Add event listener for the remove button in the new section
    newSection.querySelector('.remove-education').addEventListener('click', function () {
      this.closest('.repeater-section').remove();  // Correctly remove the entire repeater section
    });

    educationIndex++;
  });

  // Add event listeners for any initial remove buttons that might already exist
  document.querySelectorAll('.remove-education').forEach(function (button) {
    button.addEventListener('click', function () {
      this.closest('.repeater-section').remove();  // Ensure the entire section is removed
    });
  });
});
