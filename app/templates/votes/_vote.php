<?php

if (isset($_POST['element_include']) && !empty($_POST['vote_id'])) {

  # require database connection
  require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

  if(!LOGGED) exit(NULL);

  $post_entry = true;
  $element_include = true;
  $voted = true;
  $vote_id = (int) htmlspecialchars($_POST['vote_id']);
  $my_vote_id = (int) $vote_id;

  $q =
    "SELECT *, votes.id vote_id, users.id user_id
    FROM votes
    JOIN users ON users.id = votes.user_id
    WHERE votes.id = ?
    LIMIT 1";
  $p = [$vote_id];
  $get_vote = $M->select($q, $p, false);
  $v = $get_vote->fetch;

  if(!$get_vote->status) exit(NULL);
}

if (!isset($element_include, $voted)) exit(NULL);

?>

<box-model shadowed="std" light white rounded="wide" class="mb12 <?php echo $post_entry ? 'animated fallIn' : ''; ?>" data-vote-id="<?php echo $v->vote_id; ?>"
  casted="<?php echo $v->vote_id == $my_vote_id ? 'true' : 'false'; ?>">
  <bm-inr size="mid">
    <form method="POST" data-form="votes,time">
      <div class="posrel">

        <div class="lt">
          <user-icon rounded="mid" size="std" class="lt" color="purple6">
            <p class="tac"><?php echo substr($v->mail, 0, 2); ?></p>
          </user-icon>

          <div class="lt ml32" style="margin-top:.9em;">
            <i class="ri-arrow-right-fill std" color="transparent"></i>
          </div>

          <div class="lt disfl fldirrow ml32" style="margin-top:.9em;">
            <p class="mr12"><i class="ri-git-commit-line mid"></i></p>
            <p style="color:#333;font-size:2em;font-weight:400;">
              <input type="hidden" value="<?php echo substr($v->time, 0, 2); ?>" name="hour" />
              <input type="hidden" value="<?php echo substr($v->time, 3, 2); ?>" name="minute" />
              <?php echo substr($v->time, 0, 5); ?>
            </p>
          </div>
        </div>

        <div class="rt">
          <outlined-text data-react="votes,submit,count" class="lt mr24" rounded="mid">
            <i class="ri-user-smile-line"></i>
            <span><?php echo $v->count; ?></span>
          </outlined-text>

          <?php if ($voted || $post_entry) { ?>

          <button-model class="lt" size="std" color="orange5" dark rounded="mid" disabled>
            <?php if ($v->vote_id == $my_vote_id) { ?>
            <i class="ri-check-line"></i>
            <?php } else { ?>
            <i class="ri-subtract-line"></i>
            <?php } ?>
          </button-model>

          <?php } else { ?>

          <button-model class="lt" size="std" color="orange" dark rounded="mid" hover-shadowed submit-closest>
            <i class="ri-send-plane-2-fill"></i>
          </button-model>

          <?php } ?>

          <div class="cl"></div>
        </div>

        <div class="cl"></div>
      </div>
    </form>
  </bm-inr>
</box-model>