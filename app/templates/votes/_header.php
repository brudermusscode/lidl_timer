<?php if (!isset($voted)) exit(NULL); ?>

<votes-header style="background: url(/app/assets/images/6385641.jpg) center 30% no-repeat;background-size: cover;"
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

<div style="height:34em;"></div>