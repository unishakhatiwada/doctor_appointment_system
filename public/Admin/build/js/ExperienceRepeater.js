document.addEventListener('DOMContentLoaded', function () {
  var experienceIndex = 1;

  // Function to add new experience entry
  document.getElementById('addExperience').addEventListener('click', function() {
    var repeater = document.getElementById('experienceRepeater');
    var newSection = document.createElement('div');
    newSection.classList.add('repeater-section');
    newSection.innerHTML = `
            <hr />
              <h3 class="text-center text-bold text-teal">Additional Experience Information</h3>
            <div class="row">
                <!-- Column 1 -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="job_title">Job Title <i class="fas fa-id-badge"></i></label>
                        <input type="text" class="form-control" name="experience[${experienceIndex}][job_title]" required>
                    </div>

                    <div class="form-group">
                        <label for="type_of_employment">Type of Employment <i class="fas fa-briefcase"></i></label>
                        <select class="form-control" name="experience[${experienceIndex}][type_of_employment]" required>
                            <option value="full_time">Full-Time</option>
                            <option value="part_time">Part-Time</option>
                            <option value="contract">Contract</option>
                            <option value="internship">Internship</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="health_care_name">Healthcare Name</label>
                        <input type="text" class="form-control" name="experience[${experienceIndex}][health_care_name]" required>
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="health_care_location">Healthcare Location</label>
                        <input type="text" class="form-control" name="experience[${experienceIndex}][health_care_location]" required>
                    </div>

                    <div class="form-group">
                        <label for="experience_start_date">Start Date <i class="fas fa-calendar-alt"></i></label>
                        <input type="date" class="form-control" name="experience[${experienceIndex}][start_date]" required>
                    </div>

                    <div class="form-group">
                        <label for="experience_end_date">End Date <i class="fas fa-calendar-alt"></i></label>
                        <input type="date" class="form-control" name="experience[${experienceIndex}][end_date]">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="experience_additional_detail">Additional Details</label>
                <textarea class="form-control" name="experience[${experienceIndex}][additional_detail]" rows="2"></textarea>
            </div>

            <div class="form-group">
                <label for="experience_certificate">Certificate (PDF)</label>
                <input type="file" class="form-control-file" name="experience[${experienceIndex}][certificate]" accept="application/pdf">
            </div>

            <!-- Remove button for the repeater -->
            <div class="d-flex justify-content-end">
                 <button type="button" class="remove-experience btn btn-danger">Remove Experience</button>
            </div>
            <hr />`;

    // Append new section
    repeater.appendChild(newSection);

    // Add remove functionality to the newly added section
    newSection.querySelector('.remove-experience').addEventListener('click', function() {
      this.closest('.repeater-section').remove();  // Correctly remove the entire repeater section
    });

    experienceIndex++;
  });

  // Add remove functionality to the initial experience section
  document.querySelectorAll('.remove-experience').forEach(function(button) {
    button.addEventListener('click', function() {
      this.closest('.repeater-section').remove();  // Ensure the entire section is removed
    });
  });
});