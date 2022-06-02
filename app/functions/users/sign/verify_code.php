<?php
# script for confirming created verification keys
# at login (create a session here)

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if(empty($_POST['mail']) || empty($_POST['code']) || LOGGED) exit(json_encode($return));

(string) $mail = $_POST['mail'];
(string) $code = $_POST['code'];

# invalid key
if (!is_numeric($code) || !strlen($code) === 4) {
  $return->message = get_msg(2);
  exit(json_encode($return));
}

# check if mail still is valid
if(!$Sign->validateMail($mail)) {
  $return->message = get_msg(1);
  exit(json_encode($return));
}

# check if key is valid
$q =
"SELECT u.id id, ua.user_id user_id, u.username username,
u.mail mail, ua.code passcode, u.created_at created_at,
u.updated_at updated_at, u.verified_at verified_at
FROM user_authentications ua
JOIN users u ON u.id = ua.user_id
WHERE u.mail = ?
AND ua.code = ?
AND ua.updated_at IS NULL
LIMIT 1";
$p = (array) [$mail, $code];
$get_user_authentication = $M->select($q, $p, false);

if(!$get_user_authentication->status || $get_user_authentication->stmt->rowCount() < 1) {
  $return->message = get_msg(2);
  exit(json_encode($return));
}

# get username for welcome message
(string) $user_id = $get_user_authentication->fetch->user_id;
(string) $username =  $get_user_authentication->fetch->username ? $get_user_authentication->fetch->username : $mail;

# create new serial + token
$authentication_array = (object) [
  "token" => $Sign->createString(34),
  "serial" => $Sign->createString(34),
  "user_id" => $user_id
];

# BEGIN THE MOFUFGASDKLFJSDLKFJ TRANSACTIION
$pdo->beginTransaction();

# create session, user is authenticated
$create_session = $Sign->createSession($get_user_authentication->fetch, $authentication_array, false, false);

if (!$create_session) {
  $return->message = get_msg(3);
  exit(json_encode($return));
}

# update authentication entry to be used
$q = "UPDATE user_authentications SET updated_at = CURRENT_TIMESTAMP WHERE user_id = ? AND updated_at IS NULL";
$p = (array) [$user_id];
$update_user_authentication = $M->update($q, $p, true);

if (!$update_user_authentication->status) {
  $return->message = get_msg(4);
  exit(json_encode($return));
}

# prepare return
$return->status = true;
$return->message = 'Welcome back, <strong>' . $username . '</strong>!';

# exit with return - ALL FINE BRO
exit(json_encode($return));

function get_msg(int $msg_code) {
  if ($msg_code == 1) return 'Invalid mail address!';
  if ($msg_code == 2) return 'This key is invalid';
  if ($msg_code == 3) return 'Problem creating new session, please go back and request a new code';
  if ($msg_code == 4) return 'Could not update authentications, please request a new code';
  if ($msg_code == 5) return '';
}