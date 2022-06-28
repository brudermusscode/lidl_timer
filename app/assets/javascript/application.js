let scroll_height;
let $header_model;

jQuery(function () {
  let $body = $(document).find('body');
  let $app = $body.find('app');

  // show/hide header models on certain scroll height
  $header_model = $(document).find('[data-react="scroll,header"]');

  // init countdown, if page is countdown
  if ($body.attr("timer")) {
    url = "/get/home/main";
    countdown.init(url, $app);
  }

  $(document)
    // do not return on form submitting
    .on("submit", "form", function () {
      return false;
    })

    // submit closest form
    .on("click", "[submit-closest]", $(this).closest("form").trigger("submit"));

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

const info_card_exists = (append, text = false) => {
  let $info_card = append.find("info-card-model");
  let url = "/get/home/countdown/_info_card.php";

  // if info card already exists, remove it first
  if ($info_card.length > 0) {
    console.log("Info card exists, removing...");

    $info_card.attr("active", false);

    setTimeout(() => {
      $info_card.remove();
      load_info_card(url, append, text);
    }, 400);
  } else {
    console.log("No info card exists, adding new one...");

    load_info_card(url, append, text);
  }
};

const load_info_card = (url, append, text) => {
  console.log("Adding new info card...");

  $.get(url, (data) => {
    if (data) append.append(data);

    setTimeout(() => {
      append.find("info-card-model").attr("active", true);
      if (text) append.find("info-card-model p").html(text);
    }, 100);
  });
};