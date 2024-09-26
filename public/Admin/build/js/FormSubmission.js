document.addEventListener('DOMContentLoaded', function() {
  var currentStep = 0;
  showStep(currentStep);

  // Function to show the current step
  function showStep(step) {
    var steps = document.getElementsByClassName('step');
    steps[step].style.display = 'block';

    if (step === 0) {
      document.getElementById('prevBtn').style.display = 'none';
    } else {
      document.getElementById('prevBtn').style.display = 'inline';
    }

    if (step === (steps.length - 1)) {
      document.getElementById('nextBtn').style.display = 'none';
      document.getElementById('submitBtn').style.display = 'inline';
    } else {
      document.getElementById('nextBtn').style.display = 'inline';
      document.getElementById('submitBtn').style.display = 'none';
    }

    var progressBar = document.getElementById('progressBar');
    var totalSteps = steps.length;
    var progressPercentage = ((step + 1) / totalSteps) * 100;
    progressBar.style.width = progressPercentage + '%';
    progressBar.innerHTML = `Step ${step + 1} of ${totalSteps}`;
  }

  // Function to handle Next/Previous navigation
  function nextPrev(n) {
    var steps = document.getElementsByClassName('step');

    if (n === 1 && !validateStep(steps[currentStep])) {
      return false;
    }

    steps[currentStep].style.display = 'none';
    currentStep += n;

    if (currentStep >= steps.length) {
      handleSubmit();
      return false;
    }

    showStep(currentStep);
  }

  // Event listeners for Next and Previous buttons
  document.getElementById('nextBtn').addEventListener('click', function() {
    nextPrev(1);
  });

  document.getElementById('prevBtn').addEventListener('click', function() {
    nextPrev(-1);
  });

  // Function to handle form submission for the current step
  function handleSubmit() {
    const currentStepId = getCurrentStep();
    const route = getRouteForStep(currentStepId);

    if (route) {
      document.getElementById('multiStepForm').action = route;
      document.getElementById('multiStepForm').submit();
    } else {
      console.error('No route found for the current step: ' + currentStepId);
    }
  }

  // Function to get the current step's ID
  function getCurrentStep() {
    const steps = document.getElementsByClassName('step');
    return steps[currentStep].id;
  }

  // Function to get the route for the current step
  function getRouteForStep(stepId) {
    const route = stepRoutes.find(route => route.step === stepId);
    return route ? route.route : null;
  }

  // Basic validation for each step
  function validateStep(step) {
    var valid = true;
    var inputs = step.querySelectorAll('input, select, textarea');

    inputs.forEach(function(input) {
      if (input.tagName === 'SELECT') {
        if (input.value === '') {
          input.classList.add('is-invalid');
          valid = false;
        } else {
          input.classList.remove('is-invalid');
        }
      } else if (!input.checkValidity()) {
        input.classList.add('is-invalid');
        valid = false;
      } else {
        input.classList.remove('is-invalid');
      }
    });

    return valid;
  }
});
