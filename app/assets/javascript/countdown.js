jQuery(function () {
  let body = $("body");

  // load countdown into body
  if (body.attr("timer") !== "false") {
    load_countdown(
      "/get/home/countdown/_countdown",
      $(document).find('[data-react="countdown,load"]')
    );
  }
});

const load_countdown = (url, append) => {
  let $url = url;
  let $append = append;
  let $countdown_container;

  $.ajax({
    url: $url,
    data: { element_include: true },
    dataType: "HTML",
    method: "POST",
    success: (data) => {
      $append.append(data);
      $countdown_container = $(document).find("countdown");
      $countdown_container.attr("active", "true");

      setTimeout(() => {
        show_info_card();
      }, 1200);
    },
    error: (data) => {
      console.error(data);
    },
  });
};

const get_due_time = (url) => {
  let due = {};

  $.ajax({
    url: url,
    // TODO: dont use sync ajax request. Find a better way to access ajax
    // return data inside this function
    async: false,
    // ------
    dataType: "JSON",
    method: "POST",
    success: (data) => {
      due = data;
    },
    error: (data) => {
      console.error(data);
    },
  });

  console.log(due, "1");

  return due;
};
