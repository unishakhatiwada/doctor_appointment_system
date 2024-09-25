document.addEventListener('DOMContentLoaded', function() {
  var currentStep = 0; // Keep track of the current step
  showStep(currentStep); // Display the initial step

  // Function to display the current step
  function showStep(step) {
    var steps = document.getElementsByClassName('step');
    steps[step].style.display = 'block'; // Show the current step

    // Hide the "Previous" button on the first step
    if (step === 0) {
      document.getElementById('prevBtn').style.display = 'none';
    } else {
      document.getElementById('prevBtn').style.display = 'inline';
    }

    // Change the "Next" button to "Submit" on the last step
    if (step === (steps.length - 1)) {
      document.getElementById('nextBtn').innerHTML = 'Submit';
    } else {
      document.getElementById('nextBtn').innerHTML = 'Next';
    }

    // Update the progress bar
    var progressBar = document.getElementById('progressBar');
    var totalSteps = steps.length;
    var progressPercentage = ((step + 1) / totalSteps) * 100;

    // Set the width of the progress bar
    progressBar.style.width = progressPercentage + '%';

    // Update the progress bar text
    progressBar.innerHTML = `Step ${step + 1} of ${totalSteps}`;
  }

  // Function to handle Next/Previous navigation
  function nextPrev(n) {
    var steps = document.getElementsByClassName('step');

    // Validate the current step before moving forward
    if (n === 1 && !validateStep(steps[currentStep])) {
      return false; // Stop if validation fails
    }

    // Hide the current step
    steps[currentStep].style.display = 'none';

    // Increase or decrease the current step by 1
    currentStep += n;

    // If the user clicks "Submit", submit the form
    if (currentStep >= steps.length) {
      document.getElementById('doctorForm').submit();
      return false;
    }

    // Otherwise, display the correct step
    showStep(currentStep);
  }

  // Event listeners for Next and Previous buttons
  document.getElementById('nextBtn').addEventListener('click', function() {
    nextPrev(1);
  });

  document.getElementById('prevBtn').addEventListener('click', function() {
    nextPrev(-1);
  });

  // Function to validate the current step
  function validateStep(step) {
    var valid = true;
    var inputs = step.querySelectorAll('input, select, textarea');

    inputs.forEach(function(input) {
      // Check if it's a select element
      if (input.tagName === 'SELECT') {
        // If the selected value is empty, it means the user didn't select a valid option
        if (input.value === '') {
          input.classList.add('is-invalid'); // Add Bootstrap's invalid class
          var errorMessage = input.nextElementSibling;
          if (errorMessage && errorMessage.classList.contains('invalid-feedback')) {
            errorMessage.textContent = `Please select a ${input.previousElementSibling.textContent.trim()} field`;
          }
          valid = false;
        } else {
          input.classList.remove('is-invalid'); // Remove invalid class if valid
        }
      } else if (!input.checkValidity()) { // For input and textarea elements
        input.classList.add('is-invalid'); // Add Bootstrap's invalid class
        var errorMessage = input.nextElementSibling;
        if (errorMessage && errorMessage.classList.contains('invalid-feedback')) {
          errorMessage.textContent = `Please fill the ${input.previousElementSibling.textContent.trim()} field`;
        }
        valid = false;
      } else {
        input.classList.remove('is-invalid'); // Remove invalid class if valid
      }
    });

    return valid; // Return true if all fields are valid, otherwise false
  }
});

