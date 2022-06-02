<box-model white rounded="wide" shadowed="mid" class="flb100">
  <bm-inr wide>
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
  </bm-inr>
</box-model>