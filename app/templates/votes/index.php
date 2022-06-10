<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if (!LOGGED) header('location: /');

# init page
$page = 'votes/index';
$voted = false;
$today_date = date('Y-m-d');

# check if voted already
# check if user voted already for today
$q =
  "SELECT uv.id, v.time time
  FROM user_votes uv
  JOIN votes v ON v.id = uv.vote_id
  WHERE uv.user_id = ?
  AND v.date = ?
  LIMIT 1";
$p = [$my->id, $today_date];
$get_user_vote = $M->select($q, $p, false);

if(!$get_user_vote->status) header(NOT_FOUND);
if($get_user_vote->stmt->rowCount() > 0) {
  # set voted to true
  $voted = true;

  # get vote time
  $vote_time = $get_user_vote->fetch->time;

  # substring vote time into hour and minute
  $hour = substr($vote_time, 0, 2);
  $minute = substr($vote_time, 3, 2);
}

# get all votes
$q =
  "SELECT *
  FROM votes
  JOIN users ON users.id = votes.user_id
  WHERE votes.date = CURRENT_DATE
  ORDER BY votes.time DESC";
$p = [];
$get_votes = $M->select($q, $p, true);

if(!$get_votes->status) header(NOT_FOUND);

include_once TEMPLATE . '/layout/head.php';
include_once TEMPLATE . '/layout/header.php';

?>

<votes-header style="background: url(/app/assets/images/5930878.jpg) center no-repeat;background-size: cover;"
  <?php echo $voted ? 'disabled' : ''; ?>>
  <div class="vh-inr">
    <form data-form="votes,time" method="POST">

      <label big centered light text-shadowed class="mb24">
        <span></span>
      </label>

      <time-picker data-time-picker="main" class="mb62">
        <div class="tp-inr">

          <div data-action="time-picker,manipulate" class="arrow left">
            <i class="ri-arrow-left-fill std"></i>
          </div>

          <div class="time">
            <div class="show hour">
              <span>hour</span>
              <input type="text" value="<?php echo $voted ? $hour : '12'; ?>" name="hour" />
            </div>
            <div class="show minute">
              <span>minute</span>
              <input type="text" value="<?php echo $voted ? $minute : '00'; ?>" name="minute" />
            </div>
          </div>

          <div data-action="time-picker,manipulate" class="arrow right">
            <i class="ri-arrow-right-fill"></i>
          </div>

        </div>
      </time-picker>

      <div class="actions disfl fldirrow flEnd">
        <p class="already-voted">
          Come back tomorrow for voting
        </p>

        <button-model size="std" color="light" dark rounded shadowed
          <?php echo $voted ? 'disabled' : 'hover-shadowed submit-closest'; ?>>
          <i class="ri-send-plane-2-fill"></i>
        </button-model>

        <div class="cl"></div>
      </div>
    </form>
  </div>
</votes-header>

<main class="centered smol" style="padding:2.4em 0;">

  <label std dark>
    <div class="text lt">Cast votes</div>
    <div class="icon lt">
      <i class="ri-arrow-down-fill"></i>
    </div>

    <div class="cl"></div>
  </label>

  <div>

    <?php foreach ($get_votes->fetch as $v) { ?>

      <box-model shadowed="std" light white rounded="wide" class="mb12">
        <bm-inr std>
          <div class="posrel">

            <user-icon rounded="mid" size="std" class="lt" color="orange">
              <p class="tac"><?php echo substr($v->mail, 0, 2); ?></p>
            </user-icon>

            <div class="lt">
              <p style="color:#333;font-size:2.4em;font-weight:400;">
                <?php echo substr($v->time, 0, 5); ?>
              </p>
            </div>

            <button-model class="rt" size="std" color="orange" dark rounded="mid"
              <?php echo $voted ? 'disabled' : 'hover-shadowed submit-closest'; ?>>
              <i class="ri-send-plane-2-fill"></i>
            </button-model>

            <?php if($v->count > 1) { ?>
              <outlined-text class="rt mr24" rounded="mid">
                  <i class="ri-user-smile-line"></i>
                  <span><?php echo $v->count - 1; ?></span>
              </outlined-text>
            <?php } ?>

            <div class="cl"></div>
          </div>
        </bm-inr>
      </box-model>

    <?php } ?>

  </div>
</main>

<script>
jQuery(function() {

  let $t, formData, url;

  $(document)

    .on('submit', '[data-form="votes,time"]', function() {

      $t = $(this);
      $voted_header = $t.closest('votes-header');
      $submit_button = $voted_header.find('[submit-closest]');
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

          if (data.status) {
            $voted_header.attr('disabled', 'true');
            $submit_button.removeAttr('submit-closest');
            $submit_button.removeAttr('hover-shadowed');
          }

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