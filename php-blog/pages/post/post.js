$(function () {
  $('#post-form').on('submit', function () {
    const queryString = window.location.search;
    title_input = $("input[name='title']");
    description_input = $("input[name='description']");
    category_input = $("input[name='category']");
    file_input = $("input[name='file']");

    if (title_input.val() == '' || title_input.val() == null) {
      $('#js-errors').html('O título é obrigatório.');
      return false;
    }

    if (description_input.val() == '' || description_input.val() == null) {
      $('#js-errors').html('A descrição é obrigatória.');
      return false;
    }

    if (category_input.val() == '' || category_input.val() == null) {
      $('#js-errors').html('A categoria é obrigatória.');
      return false;
    }

    if (queryString.length === 0) {
      if (file_input.val() == '' || file_input.val() == null) {
        $('#js-errors').html('O arquivo é obrigatório.');
        return false;
      }
    }

    return true;
  });
});
