
// Function to validate the password and confirm password fields
function validatePassword(password, passwordConfirmation) {
  let isValid = true;

  // Reset validation state
  password.classList.remove('is-invalid');
  passwordConfirmation.classList.remove('is-invalid');

  // Check if password is at least 6 characters long
  if (password.value.length < 6) {
    password.classList.add('is-invalid');
    password.nextElementSibling.nextElementSibling.innerHTML = "Password must be at least 6 characters long.";
    isValid = false;
  }

  // Check if password and confirm password match
  if (password.value !== passwordConfirmation.value) {
    passwordConfirmation.classList.add('is-invalid');
    passwordConfirmation.nextElementSibling.nextElementSibling.innerHTML = "Passwords do not match.";
    isValid = false;
  }

  return isValid; // Return validation result
}

// Toggle password visibility
document.querySelectorAll('.toggle-password').forEach(function (toggleButton) {
  toggleButton.addEventListener('click', function () {
    const input = this.closest('.input-group').querySelector('input');
    input.type = input.type === 'password' ? 'text' : 'password';
    this.classList.toggle('fa-eye-slash');
  });
});
