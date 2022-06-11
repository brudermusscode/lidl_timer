<?php if (!isset($voted)) exit(NULL); ?>

<votes-header data-react="scroll,header"
  style="background: url(/app/assets/images/6385641.jpg) center 30% no-repeat;background-size: cover;"
  <?php echo $voted || !$voting_open ? 'disabled' : ''; ?> <?php if (!$voting_open) echo "closed"; ?>>
  <div class="vh-inr">
    <form data-form="votes,time" method="POST">

      <?php if (!$voted && !$voting_open) { ?>

      <label big centered light text-shadowed class="mt12">
        <p><strong>Voting's closed!</strong></p>
      </label>

      <time-picker data-time-picker="main" class="mb12">
        <div class="tp-inr">
          <div class="time">
            <div class="show hour">
              <span>hour</span>
              <input type="text" value="<?php echo substr($vote_settings->opens_at, 0, 2); ?>" />
            </div>
            <div class="show minute">
              <span>minute</span>
              <input type="text" value="<?php echo substr($vote_settings->opens_at, 3, 2); ?>" />
            </div>
          </div>
        </div>
      </time-picker>

      <label centered light text-shadowed class="mb68">
        <p>Next voting <? echo $weekend ? 'Monday' : 'Tomorrow'; ?> at</p>
      </label>

      <? } else { ?>

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
          <?php echo $voted || !$voting_open ? 'disabled' : 'hover-shadowed submit-closest'; ?>>
          <i class="ri-send-plane-2-fill"></i>
        </button-model>

        <div class="cl"></div>
      </div>

      <? } ?>

    </form>
  </div>
</votes-header>

<div data-structure="header,spacer"></div>