let loading_inveral;

jQuery(function () {
  let body = $("body");
  let $app = $(document).find('app');

  // load countdown into body
  if (body.attr("timer") !== "false") {
    url = "/get/home/countdown/_countdown";
    countdown.init(url, $app);
  }
});

const info_card_exists = (append, text = false) => {
  let $info_card = append.find("info-card-model");
  let url = "/get/home/countdown/_info_card.php";

  // if info card already exists, remove it first
  if ($info_card.length > 0) {

    console.log('Info card exists, removing...');

    $info_card.attr('active', false);

    setTimeout(() => {
      $info_card.remove();
      load_info_card(url, append, text);
    }, 400);

  } else {

    console.log('No info card exists, adding new one...');

    load_info_card(url, append, text);
  }
};

const load_info_card = (url, append, text) => {
  console.log('Adding new info card...');

  $.get(url, (data) => {
    if (data) append.append(data);

    setTimeout(() => {
      append.find("info-card-model").attr("active", true);
      if (text) append.find("info-card-model p").html(text);
    }, 100);
  });
};