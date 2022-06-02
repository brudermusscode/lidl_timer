jQuery(function () {
  $(document)

    // do not return on form submitting
    .on('submit', 'form', function () { return false })

    // submit closest form
    .on("click", "[submit-closest]", function () {
      let $t = $(this);
      let $form = $t.closest("form");

      $form.trigger('submit');
    });
});