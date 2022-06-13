<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if (empty($_POST['element_include'])) exit(NULL);

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

# spit out the following, if the countdown is running
if(!$countdown_running) { ?>

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
</s>

<info-card-model>
  <pulse color="orange"></pulse>
  <div class="icm-inr">
    <p>
      <?php

        if ($weekend) {
          echo 'Voting opens on Monday at ' . substr($vote_settings->opens_at, 0, 5) . " o'clock!";
        } else {
          if ($voting_open) {
            if (!LOGGED) {
              echo 'Login to cast your vote - Votings are open till ' . substr($vote_settings->closes_at, 0, 5) . " o'clock!";
            } else {
              if (!$voted) echo 'Cast your vote now - Votings are open till ' . substr($vote_settings->closes_at, 0, 5) . " o'clock!";
              if ($voted) echo 'Countdown starts at ' . substr($vote_settings->closes_at, 0, 5) . " o'clock!";
            }
          } else {
            echo 'Next voting tomorrow at ' . substr($vote_settings->opens_at, 0, 5) . " o'clock!";
          }
        }

    ?>
    </p>
  </div>
</info-card-model>

<?php

# if the countdown is inactive, give the following
} else { ?>

<!-- PYRO MAN -->
<div data-structure="countdown,pyro" class="pyro">
    <div class="before"></div>
    <div class="after"></div>
</div>

<!-- the countdown -->
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
</s>

<!-- the information on bottom -->
<info-card-model>
  <pulse color="orange"></pulse>
  <div class="icm-inr">
    <p><?php echo 'Meeting at ' . substr($countdown_fetch->time, 0, 5) . " o'clock"; ?></p>
  </div>
</info-card-model>

<script type="text/javascript">
jQuery(function() {
  setTimeout(() => {
    $(document).find('s').addClass('active');
  }, 1100);
});
</script>

<script type="text/javascript">
let $pyro = document.querySelector('.pyro');
let $output_hours = document.getElementById("countdown_hours");
let $output_minutes = document.getElementById("countdown_minutes");
let $output_seconds = document.getElementById("countdown_seconds");
let due = get_due_time('/do/countdown/get_timestamps');
let exact_due = new Date(due.due_timestamp).getTime();

let x = setInterval(() => {
  let now = new Date().getTime();

  let distance = exact_due - now;
  let days = Math.floor(distance / (1000 * 60 * 60 * 24));
  let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  let seconds = Math.floor((distance % (1000 * 60)) / 1000);

  hours = hours < 10 ? "0" + hours : hours;
  minutes = minutes < 10 ? "0" + minutes : minutes;
  seconds = seconds < 10 ? "0" + seconds : seconds;

  $output_hours.innerHTML = hours;
  $output_minutes.innerHTML = minutes;
  $output_seconds.innerHTML = seconds;

  if (distance < 1) {
    // explosions
    $pyro.style.visibility = 'visible';
    $pyro.style.opacity = '1';

    // manipulate info card
    show_info_card("Countdown is done! Let's go to LIDL!");

    // get audio
    const audioContext = new AudioContext();
    const element = document.querySelector("audio");
    const source = audioContext.createMediaElementSource(element);

    source.connect(audioContext.destination);
    element.play();

    // manipulate the countdown output
    $output_hours.innerHTML = "LE";
    $output_minutes.innerHTML = "TS";
    $output_seconds.innerHTML = "GO";

    // clear the interval mate
    clearInterval(x);
  }
}, 1000);
</script>

<?php } ?>