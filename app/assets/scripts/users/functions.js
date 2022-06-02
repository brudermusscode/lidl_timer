// defines functionality related to user accounts
jQuery(function () {
  let url, formData;
  let body = $('body');

  $(document)

    // login
    .on("submit", '[data-form="users,login"]', function () {

      let $t = $(this);
      formData = new FormData(this);

      // define ajax url
      url = '/do/users/login';

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
          console.log(data);

          responder.add(body, data.message);
        },
        error: (data) => {
          console.error(data);
        },
      });
    });
});
