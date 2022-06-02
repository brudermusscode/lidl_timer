<?php
# script for logging users into the system (create a session)

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if(empty($_POST['mail']) || LOGGED) exit(NULL);

$mail = (string) $_POST['mail'];

// check if mail is legit
if(!$Sign->validateMail($mail)) {
  $return->message = get_msg(1);
  exit(json_encode($return));
}

// check if is deltacity mail
$mail_explode = explode('@', $mail);

if($mail_explode[1] !== 'deltacity.net') {
  $return->message = get_msg(2);
  exit(json_encode($return));
}

// check if account exists
$q = "SELECT id, mail FROM users WHERE mail = ? LIMIT 1";
$p = (array) [$mail];
$get_user = $M->select($q, $p, false);

if(!$get_user->status) exit(json_encode($return));

# BEGIN NEW TRANSACTION
$pdo->beginTransaction();

// register new account if, not exist
if($get_user->stmt->rowCount() < 1) {

  # insert new account
  $q = "INSERT INTO users (mail) VALUES (?)";
  $p = [$mail];
  $insert_user = $M->insert($q, $p, false);

  if(!$insert_user->status) {
    $return->message = get_msg(3);
    exit(json_encode($return));
  }

  $user_id = $insert_user->connection->lastInsertId();
} else {

  # get user id
  $user_id = $get_user->fetch->id;
}

// create auth code entry
$code = $Sign->createCode(4);

$q = "INSERT INTO user_authentications (user_id, code) VALUES (?, ?)";
$p = [$user_id, $code];
$insert_user_authentication = $M->insert($q, $p, true);

if(!$insert_user_authentication->status) {
  $return->message = get_msg(4);
  exit(json_encode($return));
}

# prepare mail body
$mailbody = file_get_contents(ROOT . '/app/templates/mail/sign.html');
$mailbody = str_replace('%code%', $code, $mailbody);

# send mail
$send_mail = $M->send_mail($mail, "Your authentication code!", $mailbody, $main);

if (!$send_mail->status) {
  $return->message = get_msg(5);
  $return->mailer = $send_mail;

  exit(json_encode($return));
}

// prepare return
$return->status = true;

if ($dev_env) {
  $return->code = $code;
  $return->message = 'Auth-code is: <strong>' . $code . '</strong> for <strong>' . $mail . '</strong>';
} else {
  $return->message = 'A verification code has been sent to <strong>' . $mail . '</strong>!';
}

// exit with return - ALL FINE BRO
exit(json_encode($return));

function get_msg(int $msg_code) {
  if($msg_code == 1) return 'You have entered an invalid mail address';
  if($msg_code == 2) return 'Please use your <strong>deltacity.net</strong> mail address';
  if($msg_code == 3) return 'Could not create new account, please try again';
  if($msg_code == 4) return 'Could not create authentication, please try again';
  if($msg_code == 5) return 'Could not send verification mail, please try again';
}