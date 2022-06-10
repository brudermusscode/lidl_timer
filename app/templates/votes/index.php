<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if (!LOGGED) header('location: /');

# init page
$page = 'votes/index';

include_once TEMPLATE . '/layout/head.php';
include_once TEMPLATE . '/layout/header.php';

?>

<main class="centered smol">
  <div style="position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);">
    <form data-form="votes,time" method="POST">

      <time-picker>
        <div class="tp-inr">

          <div data-action="time-picker,manipulate" class="arrow left">
            <i class="ri-arrow-left-fill std"></i>
          </div>

          <div class="time">
            <div class="show hour">
              <input type="text" value="12" name="hour" />
            </div>
            <div class="show minute">
              <input type="text" value="00" name="minute" />
            </div>
          </div>

          <div data-action="time-picker,manipulate" class="arrow right">
            <i class="ri-arrow-right-fill"></i>
          </div>

        </div>
      </time-picker>

      <div class="mt42 disfl fldirrow flCenter">
        <button-model submit-closest size="wide" color="orange" dark rounded hover-shadowed shadowed>
          <p>Vote</p>
        </button-model>
      </div>

    </form>
  </div>
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