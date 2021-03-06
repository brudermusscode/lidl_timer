// defines functionality related to user accounts
jQuery(function () {
  let url, formData;
  let body = $("body");

  $(document)
    // login >> request code
    .on("submit", '[data-form="users,login"]', function () {
      let $t = $(this);
      formData = new FormData(this);

      // define ajax url
      url = "/do/users/sign/request_code";

      $.ajax({
        data: formData,
        url: url,
        method: $t.attr("method"),
        dataType: "JSON",
        // important for using formData
        contentType: false,
        processData: false,
        // --
        success: (data) => {
          if (data.status) {
            $login_container = $t.closest("[login]").addClass("disn");
            $code_container = $login_container.next();
            $code_container.css({
              opacity: 1,
              display: "block",
              height: "auto",
              overflow: "visible",
            });
            $code_container.find('input[name="mail"]').val(data.mail);
            $code_container.find('input[name="code"]').focus();
          }

          responder.add(body, data.message);
        },
        error: (data) => {
          console.error(data);
        },
      });
    })

    // login >> verify code
    .on("submit", '[data-form="users,login,verify_code"]', function () {
      let $t = $(this);
      formData = new FormData(this);

      // define ajax url
      url = "/do/users/sign/verify_code";

      $.ajax({
        data: formData,
        url: url,
        method: $t.attr("method"),
        dataType: "JSON",
        // important for using formData
        contentType: false,
        processData: false,
        // --
        success: (data) => {
          if (data.status) {
            setTimeout(() => {
              window.location.replace("/");
            }, 2000);
          }

          responder.add(body, data.message);
        },
        error: (data) => {
          console.error(data);
        },
      });
    });
});
