<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

?>

<info-card-model>
  <pulse color="orange"></pulse>
  <div class="icm-inr">
    <p>
      <?php

        if ($weekend) {
          echo 'Voting opens on Monday at ' . substr($vote_settings->opens_at, 0, 5) . " o'clock!";
        } else {
          if (!$countdown_running) {
            if ($voting_open) {
              if (!LOGGED) {
                echo 'Login to cast your vote - Votings are open till ' . substr($vote_settings->closes_at, 0, 5) . " o'clock!";
              } else {
                if (!$my->voted) {
                  echo 'Cast your vote now - Votings are open till ' . substr($vote_settings->closes_at, 0, 5) . " o'clock!";
                } else {
                  echo 'Countdown starts at ' . substr($vote_settings->closes_at, 0, 5) . " o'clock!";
                }
              }
            } else {
              echo 'Next voting ' . $voting_starts_text . ' at ' . substr($vote_settings->opens_at, 0, 5) . " o'clock!";
            }
          } else {
            echo 'Meeting at ' . substr($countdown_fetch->time, 0, 5) . " o'clock";
          }
        }

    ?>
    </p>
  </div>
</info-card-model>