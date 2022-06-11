<box-model data-structure="users,login-container" white rounded="wide" shadowed class="flb100">
  <bm-inr>
    <div login>
      <label big dark centered>
        <span></span>
      </label>

      <div class="mb42">
        <p class="tac">Hungry? Enter your details and get a verification code</p>
      </div>

      <form method="POST" data-form="users,login">
        <div class="inputs--outer">
          <div class="mb12">
            <input autofocus type="email" name="mail" class="w100" placeholder="E-Mail address (@deltacity.net)" light
              slight rounded autocomplete="true" />
          </div>
        </div>

        <div class="mt12 mb32">
          <p>Trouble? Write <strong>Justin</strong> on Mattermost</p>
        </div>

        <div class="actions disfl fldirrow gap-std">
          <button-model style="flex-basis:20%;" size="std" color="white" dark rounded="mid" hover-shadowed
            onclick="history.back();">
            <p><i class="ri-arrow-left-fill"></i></p>
          </button-model>
          <button-model style="flex-basis:80%;" submit-closest size="std" color="orange" dark rounded="mid"
            hover-shadowed>
            <p>Login</p>
          </button-model>
        </div>
      </form>

      <div class="mt38 mb24">
        <p class="tac mt12">No account? Just enter your <strong>@deltacity.net</strong> address.</p>
      </div>
    </div>

    <div code style="opacity:0;transition:opacity .2s ease-out;height:0;overflow:hidden;">
      <label big dark centered class="tac" style="padding:.8em 0;">
        <span>Code sent!</span>
      </label>

      <div class="mb42">
        <p class="tac mt12">No code received?</p>
        <p class="tac">Reload the page and request a new one</p>
      </div>

      <form method="POST" data-form="users,login,verify_code">
        <div class="inputs--outer">
          <div class="mb12">
            <input type="hidden" name="mail" value="" />
            <input type="text" name="code" class="w100" placeholder="Verification code" light slight rounded
              autocomplete="true" />
          </div>
        </div>

        <div class="actions mt32">
          <button-model submit-closest size="std" color="orange" dark rounded="mid" hover-shadowed>
            <p>Verify</p>
          </button-model>
        </div>
      </form>
    </div>
  </bm-inr>
</box-model>