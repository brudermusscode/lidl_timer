<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

# set current page
$page = 'Index';

$due_date = date('2022-06-03');
$due_time = date('12:20:00');
$due = $due_date . ' ' . $due_time;

include_once TEMPLATE . "/layout/head.php";
include_once TEMPLATE . "/layout/header.php";

?>

<s>
  <div class="lidl-text">
    <logo>
      <p>
        L
        <span class="the-i">i</span>
        <span class="logo-spacer">DL</span>
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

  <div class="countdown-desc disn">
    Countdown coming soon
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

  if (distance < 0) {
    // explosions


    // clear the interval mate
    clearInterval(x);
  }
}, 1000);
</script>

<?php include_once TEMPLATE . "/layout/footer.php"; ?>