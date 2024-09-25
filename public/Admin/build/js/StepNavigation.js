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
  }

  // Function to handle Next/Previous navigation
  function nextPrev(n) {
    var steps = document.getElementsByClassName('step');
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
});
