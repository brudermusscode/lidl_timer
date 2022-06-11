jQuery(function () {
  // predefine vars
  let $t, formData, url, $votes_header, scroll_height;

  // get vote header
  $votes_header = $(document).find("votes-header");

  // show/hide vote header on certain scroll height
  $(window).on("scroll", function () {
    scroll_height = 80;

    if (
      $votes_header.attr("scrolled") == "true" &&
      $(this).scrollTop() >= scroll_height
    )
      return false;

    if ($(this).scrollTop() >= scroll_height) {
      $votes_header.attr("scrolled", "true");
      console.log("scrolling...");
    } else {
      $votes_header.attr("scrolled", "false");
    }
  });

  // functionality for voting
  $(document).on("submit", '[data-form="votes,time"]', function () {
    $t = $(this);
    let $submit_button = $votes_header.find("[submit-closest]");
    let $votes_casted_container = $(document).find(
      '[data-structure="votes,casted"]'
    );
    let $votes_casted_empty_box = $votes_casted_container.find(
      '[data-react="votes,cast,empty"]'
    );

    // get time picker elements
    $hour = $votes_header.find('input[name="hour"]');
    $minute = $votes_header.find('input[name="minute"]');
    let $vote_casted;

    // serialize form data
    formData = new FormData(this);

    // set ajax url
    url = "/do/votes/add_time";

    $.ajax({
      data: formData,
      url: url,
      dataType: "JSON",
      method: $t.attr("method"),
      contentType: false,
      processData: false,
      success: (data) => {
        console.log(data);

        if (data.status) {
          // remove empty container
          $votes_casted_empty_box.remove();

          // find casted vote
          $vote_casted = $votes_casted_container.find(
            'box-model[data-vote-id="' + data.data.vote_id + '"]'
          );

          // set current vote to casted
          $vote_casted.attr("casted", "true");

          // disable votes header
          $votes_header.attr("disabled", "true");
          $submit_button.removeAttr("submit-closest");
          $submit_button.removeAttr("hover-shadowed");

          // manipulate date picker time
          $hour.val(data.data.hour);
          $minute.val(data.data.minute);

          // disable all votes casted
          $votes_casted_container.find("button-model").attr("disabled", "true");
          $votes_casted_container
            .find("button-model")
            .removeAttr("hover-shadowed");
          $votes_casted_container
            .find("button-model")
            .removeAttr("submit-closest");

          // only do, if new vote was added
          if (!data.data.new_vote) {
            // manipulate new vote count
            $vote_casted.find('[data-react="votes,submit,count"] span').html(data.data.vote_count);

            $("html,body").animate(
              {
                scrollTop: $(
                  '[data-vote-id="' + data.data.vote_id + '"]'
                ).offset().top,
              },
              "slow"
            );
          } else {
            // get new vote
            url = "/get/votes/_vote";

            $.ajax({
              url: url,
              data: {
                element_include: true,
                vote_id: data.data.vote_id,
              },
              dataType: "HTML",
              method: "POST",
              success: (data) => {
                $votes_casted_container.prepend(data);
              },
              error: (data) => {
                console.error(data);
              },
            });
          }
        }

        responder.add($("body"), data.message);
      },
      error: (data) => {
        console.error(data);
      },
    });
  });
});
