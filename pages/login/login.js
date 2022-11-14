$(function () {
  $('#login-form').on('submit', function () {
    email_input = $("input[name='email']");
    password_input = $("input[name='password']");

    if (email_input.val() == '' || email_input.val() == null) {
      $('#js-errors').html('Email é obrigatório.');
      $('#js-errors').css('height', '30px');
      return false;
    }

    if (password_input.val() == '' || password_input.val() == null) {
      $('#js-errors').html('A senha é obrigatória.');
      $('#js-errors').css('height', '30px');
      return false;
    }

    return true;
  });
});
