
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');
  const eyeIconPassword = document.querySelector('#eyeIconPassword');

  togglePassword.addEventListener('click', function() {
  const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
  password.setAttribute('type', type);
  eyeIconPassword.classList.toggle('fa-eye');
  eyeIconPassword.classList.toggle('fa-eye-slash');
});

  const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
  const confirmPassword = document.querySelector('#password_confirmation');
  const eyeIconConfirm = document.querySelector('#eyeIconConfirm');

  toggleConfirmPassword.addEventListener('click', function() {
  const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
  confirmPassword.setAttribute('type', type);
  eyeIconConfirm.classList.toggle('fa-eye');
  eyeIconConfirm.classList.toggle('fa-eye-slash');
});

