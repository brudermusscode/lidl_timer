// defines functionality related to user accounts
jQuery(function () {
  $(document)

    // login
    .on("submit", '[data-form="users,login"]', function () {

      let $t = $(this);
      let formData = new FormData(this);

      console.log('Init user login...');

      $.ajax({
        data: formData,
        method: $t.attr("method"),
        dataType: "JSON",
        // important for using formData
        contentType: false,
        processData: false,
        // --
        success: (data) => {
          console.log(data);

          if (data.status) {
            // do something
          }
        },
        error: (data) => {
          console.error(data);
        },
      });
    });
});
