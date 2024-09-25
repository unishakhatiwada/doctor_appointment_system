document.addEventListener('DOMContentLoaded', function () {
  var educationIndex = 1;

  // Function to add new education entry
  document.getElementById('addEducation').addEventListener('click', function() {
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
                    </div>

                    <div class="form-group">
                        <label for="additional_detail">Additional Details</label>
                        <input type="text" class="form-control" name="education[${educationIndex}][additional_detail]" required>
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="college_address">College Address</label>
                        <input type="text" class="form-control" name="education[${educationIndex}][college_address]" required>
                    </div>


                    <div class="form-group">
                        <label for="faculty">Faculty</label>
                        <input type="text" class="form-control" name="education[${educationIndex}][faculty]" required>
                    </div>

                    <div class="form-group">
                        <label for="certificate">Certificate (PDF)</label>
                        <input type="file" class="form-control-file" name="education[${educationIndex}][certificate]" accept="application/pdf">
                    </div>
                </div>
            </div>
            <button type="button" class="remove-education btn btn-danger">Remove</button>
            <hr />`;

    // Append new section
    repeater.appendChild(newSection);

    // Add remove functionality to the new section
    newSection.querySelector('.remove-education').addEventListener('click', function() {
      this.parentElement.remove();
    });

    educationIndex++;
  });

  // Add remove functionality to the initial education section
  document.querySelectorAll('.remove-education').forEach(function(button) {
    button.addEventListener('click', function() {
      this.parentElement.remove();
    });
  });
});
