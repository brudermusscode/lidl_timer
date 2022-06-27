<?php
# this file holds essential methods for querying the database
# and interact with the application

# import PHPMailer classes into global namespace
use PHPMailer\PHPMailer\PHPMailer;

# init the Main class
$M = new Main($pdo, $_SESSION, $_COOKIE);

# define the Main class
class Main extends Db
{

  public function __construct(object $connection, array $session, array $cookies)
  {
    $this->pdo = (object) $connection;
    $this->session = (object) $session;
    $this->cookies = (object) $cookies;
  }

  public function get_main_settings() {
    $q = (string) "SELECT * FROM main_settings, main_urls";
    $p = (array) [];
    $get_main_settings = $this->select($q, $p, false);

    if (!$get_main_settings->status) return NULL;

    return (object) $get_main_settings->fetch;
  }

  public function insert(string $query, array $params, bool $commit = false)
  {

    (string) $query;
    (array) $params;
    (bool) $commit;

    try {

      # validate given parameters' types
      if (!is_string($query)) self::amk('Query has to be of type (string)');
      if (!is_array($params)) self::amk('Given query parameters have to be of type (array)');
      if (!is_bool($commit)) self::amk("Commit value has to be of type (bool)");

      $stmt = $this->pdo->prepare($query);
      $stmt->execute($params);

      // commit changes if true
      if ($commit) $this->pdo->commit();

      // store error information
      $r = (object) [];
      $r->status = true;
      $r->commit = $commit;
      $r->stmt = $stmt;
      $r->connection = $this->pdo;

      // return the object back to the script
      return $r;
    } catch (\PDOException $e) {

      // rollback data and return error information
      if ($commit) $this->pdo->rollback();

      // catch error information
      $r = (object) [];
      $r->status = 0;
      $r->exception = $e;
      $r->message = $e->getMessage();
      $r->code = $e->getCode();

      return $r;
    }

    return false;
  }

  public function delete(string $query, array $params, bool $commit = false)
  {

    try {

      # validate given parameters' types
      if (!is_string($query)) self::amk('Query has to be of type (string)');
      if (!is_array($params)) self::amk('Given query parameters have to be of type (array)');
      if (!is_bool($commit)) self::amk("Commit value has to be of type (bool)");

      $stmt = $this->pdo->prepare($query);
      $stmt->execute($params);

      // commit changes if true
      if ($commit) $this->pdo->commit();

      // store error information
      $r = (object) [];
      $r->status = true;
      $r->commit = $commit;
      $r->stmt = $stmt;
      $r->connection = $this->pdo;

      // return the object back to the script
      return $r;
    } catch (\PDOException $e) {

      // rollback data and return error information
      if ($commit) $this->pdo->rollback();

      // catch error information
      $r = (object) [];
      $r->status = 0;
      $r->exception = $e;
      $r->message = $e->getMessage();
      $r->code = $e->getCode();

      return $r;
    }

    return false;
  }

  # converts a simple function into a prepared update statement using
  # PDO, taking in commitment true/false, returning the statements object
  public function update(string $query, array $params, bool $commit = false)
  {

    (string) $query;
    (array) $params;
    (bool) $commit;

    # validate given parameters by their type and return an amk, if one mismatches
    if (!is_array($params)) self::amk('Given Variables have to be of type (array)');
    if (!is_string($query)) self::amk('Queries have to be of type (string)');
    if (!is_bool($commit)) self::amk("Commit value has to be of type (bool)");

    try {

      # set up new query for updating one or more records
      $stmt = $this->pdo->prepare($query);
      $stmt->execute($params);

      if ($commit) $this->pdo->commit();

      # prepare return object
      $r = (object) [];
      $r->status = true;
      $r->commit = true;
      $r->stmt = $stmt;
      $r->connection = $this->pdo;

      # otherwise return the statement's response object
      return $r;
    } catch (\PDOException $e) {

      if ($commit) $this->pdo->rollback();

      // catch error information
      $return = (object) [
        "status" => false,
        "exception" => $e,
        "message" => $e->getMessage(),
        "code" => $e->getCode()
      ];

      return $return;
    }

    return false;
  }

  # converts a simple function into an select statement and returns an object
  # with PDO query functions and records, if any
  public function select(string $query, array $params = null, bool $fetch_all = false)
  {

    (string) $query;
    (array) $params;
    (bool) $fetch_all;

    try {

      # prepare and execute statement
      $stmt = $this->pdo->prepare($query);
      $stmt->execute($params);

      # fetch records
      if ($fetch_all) {
        $fetch = $stmt->fetchAll();
      } else {
        $fetch = $stmt->fetch();
      }

      # set up return-object
      $stmt_return = (object) [
        "status" => true,
        "stmt" => $stmt,
        "fetch" => $fetch
      ];

      # return the return-object
      return $stmt_return;
    } catch (\PDOException $e) {

      // catch error information
      $return = (object) [
        "status" => false,
        "exception" => $e,
        "message" => $e->getMessage(),
        "code" => $e->getCode()
      ];

      return $return;
    }

    return false;
  }

  public function send_mail($address, $subject, $body, $web_information)
  {

    # get environment
    $environment = $this->getEnvironment();

    # check current environment and get correct connection.json
    $smtp_connection_file = ROOT . "/config/mail/smtp.connection." . $environment . ".json";

    # validate file existence
    if (!file_exists($smtp_connection_file))
      throw new Exception("💔 Configuration-file in 📂/config/mail should match 📄smtp.connection.*ENVIRONMENT*.json ❗️");

    // get login infromation from outsourced file
    $mail_config = (object) $this->convertFromFile($smtp_connection_file)->connect;

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    // SMTP needs accurate times, and the PHP time zone MUST be set
    // This should be done in your php.ini, but this is how to do it if you don't have access to that
    date_default_timezone_set('Etc/UTC');

    // Server settings
    $mail->isSMTP(); // Send using SMTP
    # $mail->SMTPDebug = PHPMailer::SMTP::DEBUG_SERVER;
    $mail->Host = $mail_config->smtp->host;
    $mail->Port = 465;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->SMTPAuth = true;
    $mail->Username = $mail_config->smtp->username;
    $mail->Password = $mail_config->smtp->password;

    // Recipients
    $mail->setFrom('lidl_timer@thinkquotes.de', $web_information->name);
    $mail->addAddress($address);

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->CharSet = PHPMailer::CHARSET_UTF8;
    $mail->Subject = $subject;
    $mail->Body = $body;
    # $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    # prepare return object
    $return = (object) [];

    try {

      $mail->send();

      # set return status to true
      $return->status = true;

      # return it
      return $return;

    } catch (Exception $e) {

      # set return object error information
      $return = (object) [
        "status" => false,
        "code" => $e->getCode(),
        "message" => $e->getMessage(),
        "response" => $mail->ErrorInfo
      ];

      # return it
      return $return;
    }
  }

  # just throw new errors with a certain message abbreviated
  public static function amk($message)
  {
    throw new Exception($message);
  }
}