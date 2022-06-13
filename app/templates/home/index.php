<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

# set current page
$page = 'home/index';

# set voted to false as default
$voted = false;

# check if user voted already for today
$q =
  "SELECT uv.id, v.id vote_id, v.time time
  FROM user_votes uv
  JOIN votes v ON v.id = uv.vote_id
  WHERE uv.user_id = ?
  AND v.date = ?
  LIMIT 1";
$p = [$my->id, $main->today->date];
$get_user_vote = $M->select($q, $p, false);

if(!$get_user_vote->status) header(NOT_FOUND);
if($get_user_vote->stmt->rowCount() > 0) {

  # set voted to true
  $voted = true;
}

include_once TEMPLATE . "/layout/head.php";
include_once TEMPLATE . "/layout/header.php";

?>

<s>
  <div class="headline-text">
    <logo>
      <p>
        L
        <span class=the-i>i</span>
        <span class=logo-spacer>DL</span>
      </p>
    </logo>
  </div>

  <div class="mover-1"></div>

  <div id="countdown" class="time">
    <div id="countdown_hours" class="time-container"></div>
    <p><span class=blink>:</span></p>
    <div id="countdown_minutes" class="time-container"></div>
    <p><span class=blink>:</span></p>
    <div id="countdown_seconds" class="time-container"></div>
  </div>

  <div class="countdown-desc">
    <?php

    if ($weekend) echo 'Voting pool opens on Monday at ' . substr($vote_settings->opens_at, 0, 5) . " o'clock!";

    if(!$weekend && $due_reached) echo 'Next voting tomorrow at ' . substr($vote_settings->opens_at, 0, 5) . " o'clock!";

    if (
      !$weekend
      && !$voting_open
      && isset($countdown_fetch)
      && !$due_reached
    ) echo 'Meeting at ' . substr($countdown_fetch->time, 0, 5) . " o'clock";

    if (!LOGGED) {
      if ($voting_open) echo 'Login to cast your vote - Votings are open!';
    } else {
      if ($voting_open && !$voted) echo 'Cast your vote now - Votings are open!';
      if ($voting_open && $voted) echo 'Countdown starts at ' . substr($vote_settings->closes_at, 0, 5) . " o'clock!";
    }
    ?>
  </div>
</s>

<script>
jQuery(function() {
  setTimeout(() => {
    $(document).find('s').addClass('active');
  }, 2000);
});
</script>

<script>
let $output_hours = document.getElementById('countdown_hours');
let $output_minutes = document.getElementById('countdown_minutes');
let $output_seconds = document.getElementById('countdown_seconds');
let due = "<?php echo $due; ?>";
let exact_due = new Date(due).getTime();

let x = setInterval(() => {

  let now = new Date().getTime();
  let distance = exact_due - now;
  let days = Math.floor(distance / (1000 * 60 * 60 * 24));
  let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  let seconds = Math.floor((distance % (1000 * 60)) / 1000);

  hours = (hours < 10) ? '0' + hours : hours;
  minutes = (minutes < 10) ? '0' + minutes : minutes;
  seconds = (seconds < 10) ? '0' + seconds : seconds;

  $output_hours.innerHTML = hours;
  $output_minutes.innerHTML = minutes;
  $output_seconds.innerHTML = seconds;

  if (distance < 1) {
    // explosions
    // -- do some explosions

    // get audio
    const audioContext = new AudioContext();
    const element = document.querySelector('audio');
    const source = audioContext.createMediaElementSource(element);

    source.connect(audioContext.destination);
    element.play();

    // manipulate the countdown output
    $output_hours.innerHTML = '00';
    $output_minutes.innerHTML = '00';
    $output_seconds.innerHTML = '00';

    // clear the interval mate
    clearInterval(x);
  }
}, 1000);
</script>

<?php include_once TEMPLATE . "/layout/footer.php"; ?>