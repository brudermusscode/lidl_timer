jQuery(function () {

  let t;
  let votes_header = $(document).find('votes-header');
  let votes_container = $(document).find('[data-structure="votes,casted"]');
  let votes_container__empty = votes_container.find('[data-react="votes,cast,empty"]');

  $(document).on('submit', '[data-form="votes,time"]', function () {

    t = $(this);
    button = t.find('[submit-closest]');
    hour = t.find('input[name="hour"]');
    minute = t.find('input[name="minute"]');
    data = new FormData(this);

    jQuery.ajax({
      url: "/do/votes/time",
      data: data,
      method: 'POST',
      contentType: !1,
      processData: !1,
      dataType: 'JSON',
      success: (data) => {
        console.log(data);

        if (data.status) {
          let votes_container__buttons = votes_container.find("button-model");

          if (!data.data.new_vote) {
            // remove votes container empty box
            votes_container__empty.remove();

            // init vote_box
            let vote_box = votes_container.find(
              'box-model[data-vote-id="' + data.data.vote_id + '"]'
            );

            // make vote box be caste
            vote_box.attr("casted", true);

            // increase vote count inside box
            vote_box
              .find('[data-react="votes,submit,count"] span')
              .html(data.data.vote_count);

            // scroll to that vote
            // let js_vote_box = document.querySelector('box-model[data-vote-id="' + data.vote_id + '"]');
            // js_vote_box.scrollIntoView({ behavior: "smooth", block: "end" });
          } else {

            let new_data = { element_include: !0, vote_id: data.data.vote_id };
            $.post(
              "/get/votes/_vote",
              new_data,
              (data) => {
                votes_container.prepend(data);
              },
              "HTML"
            );
          }

          // disable vote header
          votes_header.attr("disabled", true);
          votes_header.find("[submit-closest]").removeAttr("submit-closest");
          votes_header.find("[submit-closest]").removeAttr("hover-shadowed");

          // manipulate button
          votes_container__buttons.attr("disabled", true);
          votes_container__buttons.removeAttr("submit-closest");
          votes_container__buttons.removeAttr("hover-shadowed");

          // manipulate time
          hour.val(data.data.hour);
          minute.val(data.data.minute);
        }

        // always show responder
        responder.add($("body"), data.message);
      }
    });
  });
});
