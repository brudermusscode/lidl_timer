<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if (!LOGGED) header('location: /');

# init page
$page = 'votes/index';

include_once TEMPLATE . '/layout/head.php';
include_once TEMPLATE . '/layout/header.php';

?>

<div style="background:url(/app/assets/images/5930878.jpg) center no-repeat;background-size:cover;width:100%;"
  class="posrel">
  <main class="centered smol">
    <form data-form="votes,time" method="POST">
      <div style="padding:7em 0 2.4em;">

        <time-picker class="mb42">
          <div class="tp-inr">

            <div data-action="time-picker,manipulate" class="arrow left">
              <i class="ri-arrow-left-fill std"></i>
            </div>

            <div class="time">
              <div class="show hour">
                <span>hour</span>
                <input type="text" value="12" name="hour" />
              </div>
              <div class="show minute">
                <span>minute</span>
                <input type="text" value="00" name="minute" />
              </div>
            </div>

            <div data-action="time-picker,manipulate" class="arrow right">
              <i class="ri-arrow-right-fill"></i>
            </div>

          </div>
        </time-picker>


        <div style="margin:0 auto;width:calc(100% - 2.4em);">
          <button-model submit-closest size="std" color="light" dark rounded hover-shadowed shadowed class="rt"
            style="padding-top:.2em;">
            <i class="ri-send-plane-2-fill"></i>
          </button-model>

          <div class="cl"></div>
        </div>
      </div>
    </form>
  </main>
</div>

<main class="centered smol">

</main>

<script>
jQuery(function() {

  let $t, formData, url;

  $(document)

    .on('submit', '[data-form="votes,time"]', function() {

      $t = $(this);
      formData = new FormData(this);
      url = '/do/votes/add_time';

      $.ajax({

        data: formData,
        url: url,
        dataType: 'JSON',
        method: $t.attr('method'),
        contentType: false,
        processData: false,
        success: (data) => {
          responder.add($('body'), data.message);
        },
        error: (data) => {
          console.error(data);
        }
      });
    })

    .on('click', '[data-action="time-picker,manipulate"]', function() {

      let $t = $(this);
      let $time_picker = $t.closest('time-picker');
      let $hour = $time_picker.find('.time .hour input');
      let $minute = $time_picker.find('.time .minute input');
      let hour = parseInt($hour.val());
      let minute = parseInt($minute.val());

      // increase timer
      if ($t.hasClass('right')) {
        switch (minute) {
          case 59:
            hour = hour + 1;
            minute = 0;
            break;
          default:
            minute = minute + 1;
        }

        // decrease timer
      } else {
        switch (minute) {
          case 0:
            hour = hour - 1;
            minute = 59;
            break;
          default:
            minute = minute - 1;
        }
      }

      if (minute < 10) {
        minute = '0' + minute;
      }

      $hour.val(hour);
      $minute.val(minute);
    });

});
</script>

<?php include_once TEMPLATE . '/layout/footer.php'; ?>