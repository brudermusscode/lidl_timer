jQuery(function () {
  let t, e, o, a;
  (a = $(document).find("votes-header")),
    $(document).on("submit", '[data-form="votes,time"]', function () {
      t = $(this);
      let d,
        r = a.find("[submit-closest]"),
        s = $(document).find('[data-structure="votes,casted"]'),
        n = s.find('[data-react="votes,cast,empty"]');
      ($hour = a.find('input[name="hour"]')),
        ($minute = a.find('input[name="minute"]')),
        (e = new FormData(this)),
        (o = "/do/votes/add_time"),
        $.ajax({
          data: e,
          url: o,
          dataType: "JSON",
          method: t.attr("method"),
          contentType: !1,
          processData: !1,
          success: (t) => {
            console.log(t),
              t.status &&
                (n.remove(),
                (d = s.find(
                  'box-model[data-vote-id="' + t.data.vote_id + '"]'
                )),
                d.attr("casted", "true"),
                a.attr("disabled", "true"),
                r.removeAttr("submit-closest"),
                r.removeAttr("hover-shadowed"),
                $hour.val(t.data.hour),
                $minute.val(t.data.minute),
                s.find("button-model").attr("disabled", "true"),
                s.find("button-model").removeAttr("hover-shadowed"),
                s.find("button-model").removeAttr("submit-closest"),
                t.data.new_vote
                  ? ((o = "/get/votes/_vote"),
                    $.ajax({
                      url: o,
                      data: { element_include: !0, vote_id: t.data.vote_id },
                      dataType: "HTML",
                      method: "POST",
                      success: (t) => {
                        s.prepend(t);
                      },
                      error: (t) => {
                        console.error(t);
                      },
                    }))
                  : (d
                      .find('[data-react="votes,submit,count"] span')
                      .html(t.data.vote_count),
                    $("html,body").animate(
                      {
                        scrollTop: $(
                          '[data-vote-id="' + t.data.vote_id + '"]'
                        ).offset().top,
                      },
                      "slow"
                    ))),
              responder.add($("body"), t.message);
          },
          error: (t) => {
            console.error(t);
          },
        });
    });
});
