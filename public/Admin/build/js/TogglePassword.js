
$(document).on('click', '.toggle-password', function() {
  const input = $(this).closest('.input-group').find('input');
  const icon = $(this);
  const type = input.attr('type') === 'password' ? 'text' : 'password';
  input.attr('type', type);
  icon.toggleClass('fa-eye fa-eye-slash');
});
