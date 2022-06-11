<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if (!LOGGED) header('location: /');

# init page
$page = 'votes/index';
$voted = false;
$today_date = date('Y-m-d');

# check if user voted already for today
$q =
  "SELECT uv.id, v.id vote_id, v.time time
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
  $my_vote_id = $get_user_vote->fetch->vote_id;

  # substring vote time into hour and minute
  $hour = substr($vote_time, 0, 2);
  $minute = substr($vote_time, 3, 2);
}

# get all votes
$q =
  "SELECT *, votes.id vote_id, users.id user_id
  FROM votes
  JOIN users ON users.id = votes.user_id
  WHERE votes.date = CURRENT_DATE
  ORDER BY votes.id DESC";
$p = [];
$get_votes = $M->select($q, $p, true);

if(!$get_votes->status) header(NOT_FOUND);

include_once TEMPLATE . '/layout/head.php';
include_once TEMPLATE . '/layout/header.php';

?>

<?php include TEMPLATE . '/votes/_header.php'; ?>

<main>

  <label std light text-shadowed class="mb12">
    <div class="text lt">Cast votes</div>
    <div class="icon lt">
      <i class="ri-arrow-down-fill"></i>
    </div>

    <div class="cl"></div>
  </label>

  <div data-structure="votes,casted" <?php if ($voted) { echo 'disabled="true"'; } ?>>

    <?php

    if($get_votes->stmt->rowCount() < 1) {

      include TEMPLATE . '/votes/_empty_votes.php';

    } else {

      foreach ($get_votes->fetch as $v) {
        $post_entry = false;
        $element_include = true;
        include TEMPLATE . '/votes/_vote.php';
      }
    }

    ?>

  </div>
</main>

<script>
jQuery(function() {

  $(document)

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