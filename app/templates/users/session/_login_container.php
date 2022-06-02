<box-model white rounded="wide" shadowed="mid" class="flb100">
  <bm-inr wide>
    <div login>
      <label big dark centered>
        <span>Login fren</span>
      </label>

      <div class="mb42">
        <p class="tac mt12">No account?</p>
        <p class="tac">Just login with your <strong>@deltacity.net</strong> address.</p>
      </div>

      <form method="POST" data-form="users,login">
        <div class="inputs--outer">
          <div class="mb12">
            <input type="email" name="mail" class="w100" placeholder="E-Mail address (@deltacity.net)" light slight
              rounded autocomplete="true" />
          </div>
        </div>

        <div class="mt12 mb32">
          <p>Trouble? Write <strong>Justin</strong> on Mattermost</p>
        </div>

        <div class="actions">
          <button-model submit-closest size="wide" color="red" dark rounded hover-shadowed shadowed>
            <p>Login</p>
          </button-model>
        </div>
      </form>
    </div>

    <div code style="opacity:0;transition:opacity .2s ease-out;height:0;overflow:hidden;">
      <label big dark centered>
        <span>😍 We've sent you a code!</span>
      </label>

      <div class="mb42">
        <p class="tac mt12">No code received?</p>
        <p class="tac">Reload the page and request a new one</p>
      </div>

      <form method="POST" data-form="users,login,verify_code">
        <div class="inputs--outer">
          <div class="mb12">
            <input type="hidden" name="mail" value="js@deltacity.net" />
            <input type="text" name="code" class="w100" placeholder="Verification code" light slight rounded autocomplete="true" />
          </div>
        </div>

        <div class="actions mt32">
          <button-model submit-closest size="wide" color="red" dark rounded hover-shadowed shadowed>
            <p>Verify</p>
          </button-model>
        </div>
      </form>
    </div>
  </bm-inr>
</box-model>