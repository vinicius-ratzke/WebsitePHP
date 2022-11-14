$(function () {
  $('#register-form').on('submit', function () {
    username_input = $("input[name='username']");
    email_input = $("input[name='email']");
    password_input = $("input[name='password']");
    password_confirmation_input = $("input[name='password-confirmation']");

    if (username_input.val() == '' || username_input.val() == null) {
      $('#js-errors').html('O usuário é obrigatório.');
      $('#js-errors').css('height', '30px');
      return false;
    }

    if (email_input.val() == '' || email_input.val() == null) {
      $('#js-errors').html('O email é obrigatório.');
      $('#js-errors').css('height', '30px');
      return false;
    }

    if (password_input.val() == '' || password_input.val() == null) {
      $('#js-errors').html('A senha é obrigatória.');
      $('#js-errors').css('height', '30px');
      return false;
    }

    if (password_confirmation_input.val() == '' || password_confirmation_input.val() == null) {
      $('#js-errors').html('Confirmação de senha é obrigatória.');
      $('#js-errors').css('height', '30px');
      return false;
    }

    return true;
  });
});
