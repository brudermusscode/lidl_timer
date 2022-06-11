jQuery(function () {

  let scroll_height, $header_model;

  $(document)
    // do not return on form submitting
    .on("submit", "form", function () {
      return false;
    })

    // submit closest form
    .on("click", "[submit-closest]", function () {
      let $t = $(this);
      let $form = $t.closest("form");

      $form.trigger("submit");
    });


    // show/hide header models on certain scroll height
    $header_model = $(document).find('[data-react="scroll,header"]');

    $(window).on("scroll", function () {
      scroll_height = 80;

      if (
        $header_model.attr("scrolled") == "true" &&
        $(this).scrollTop() >= scroll_height
      )
        return false;

      if ($(this).scrollTop() >= scroll_height) {
        $header_model.attr("scrolled", "true");
        console.log("scrolling...");
      } else {
        $header_model.attr("scrolled", "false");
      }
    });
});