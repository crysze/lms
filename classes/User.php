<?php

/**
 * User
 *
 * A user's login / profile details
 */
class User {
    /**
     * Unique identifier
     *
     * @var int
     */
    public $id;

    /**
     * The user's first name
     *
     * @var string
     */
    public $firstname;

    /**
     * The user's last name
     *
     * @var string
     */
    public $lastname;

    /**
     * The user's email address (= username)
     *
     * @var string
     */
    public $email;

    /**
     * The user's password
     *
     * @var string
     */
    public $password;

    /**
     * The user's account activation code
     *
     * @var string
     */
    public $activation_code;

    /**
     * When the user's account activation window will have expired
     *
     * @var string
     */
    public $activation_expiry;

    /**
     * Creates a new user in the database
     *
     * @param $conn Database connection
     *
     * @return bool True if the database entry has been created successfully
     */
    public function create($conn) {

      $sql = 'INSERT INTO user (firstname, lastname, email, password, activation_code, activation_expiry)
              VALUES (:firstname, :lastname, :email, :password, :activation_code, :activation_expiry)';

      $stmt = $conn->prepare($sql);

      $stmt->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
      $stmt->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
      $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
      $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);
      $stmt->bindValue(':activation_code', $this->activation_code, PDO::PARAM_STR);
      $stmt->bindValue(':activation_expiry', $this->activation_expiry, PDO::PARAM_STR);

      if ($stmt->execute()) {
        $this->id = $conn->lastInsertId();

        return true;
        }
    }

    /**
     * Upon successful registration, an email is sent to the user with an email verification link they have to click to activate their account
     *
     * @param $email The user's email address
     *
     * @param $activation_code The activation code to be used as a GET parameter in the activation link
     *
     * @return void
     */

    public function send_activation_email($email, $activation_code) {

      require '../mail/mail.php';

      // Create the activation link

      $activation_link = "http://{$_SERVER['SERVER_NAME']}" . "/activate.php?email=$email&activation_code=$activation_code";

      // Set email subject and body

      $text = "Hi,<br><br>
      Please access the following link to activate your account:<br>
      <a href='$activation_link'>$activation_link</a>";

      $message = str_replace('%TEXT%', $text, $message);

      // Set who the message is to be sent to
      $mail->addAddress($email);

      // Set the subject line
      $mail->Subject = '[Code Loop] Please activate your account';

      // Set the message
      $mail->msgHTML($message);

      // Send the email
      $mail->send();
    }

    /** Deletes the user account tied to a specific ID
     *
     * @param $id The user's ID
     *
     * @return bool Returns true if the deletion has been performed successfully
     */

    public static function delete_user_by_id($conn, $id) {
      $sql = 'DELETE FROM user
      WHERE userid = :userid';

      $stmt = $conn->prepare($sql);

      $stmt->bindValue(':userid', $id, PDO::PARAM_INT);

      if ($stmt->execute()) {
        return true;
      }
    }

    /**
     * Either deletes a user after accessing the activation link if the activation timeframe has expired or activates the account if specifications are met
     *
     * @param $activation_code GET parameter from the activation link
     *
     * @param $email GET parameter which is the user's email address
     *
     * @return Arr || null
     */

    public static function handle_unverified_user($conn, $activation_code, $email) {
      /* First SQL statement compares the expiry date to the current date which resolves to 0 (false) or 1 (true) and then assigns this value to 'expired' */
      $sql = 'SELECT userid, activation_code, activation_expiry < now() AS expired
              FROM user
              WHERE active = 0 AND email = :email';

      $stmt = $conn->prepare($sql);

      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->execute();

      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      // If the current date is after the expiry date, the account is deleted and null is returned

      if (isset ($user['expired']) && isset($user['activation_code'])) {

        // $user['expired'] is a string ("0" or "1") so has to be converted to an integer to be able to compare it against 1

        if ((int)$user['expired'] === 1 && User::delete_user_by_id($conn, $user['userid'])) {
          return null;
        }

        // If the GET parameter matches the stored activation code, the user is returned as an array

        if (password_verify($activation_code, $user['activation_code'])) {
          return $user;
        }
      }

      // If none of the above is true, null is returned

      return null;
    }

    /**
     * Sets the active column of the user to 1 (true)
     *
     * @param $user_id The user's ID
     *
     * @return bool Return true if the activation was successful
     */

    public static function activate_user($conn, $user_id) {
      $sql = 'UPDATE user
      SET active = 1, activated_at = CURRENT_TIMESTAMP()
      WHERE userid = :userid';

      $stmt = $conn->prepare($sql);

      $stmt->bindValue(':userid', $user_id, PDO::PARAM_INT);

      return $stmt->execute();
    }



    /**
     * Checks if a user with a given email address already exists in the database
     *
     * @param $conn Database connection
     *
     * @param $email User's email address
     *
     * @return bool True if the email address already exists
     */
    public static function username_check($conn, $email) {
    $sql = 'SELECT *
            FROM user
            WHERE email = :email';

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);

    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Checks if the account has been activated via email verification yet
   *
  * @param $conn Database connection
  *
  * @param $email User's email address
  *
  * @return bool True if the account has already been activated
   */
  public static function is_user_active($conn, $email) {
    $sql = 'SELECT *
    FROM user
    WHERE email = :email';

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);

    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['active']) {
    return true;
    } else {
    return false;
    }
  }

  /**
   * Checks if a given email address and password match with an existing user in the database
   *
   * @param $conn Database connection
   *
   * @param $email User's email address
   *
   * @param $password User's password
   *
   * @return bool True if the credentials are correct
   */
  public static function authentication($conn, $email, $password) {
      $sql = 'SELECT *
              FROM user
              WHERE email = :email';

      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);

      $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');

      $stmt->execute();

      if ($user = $stmt->fetch()) {
          return password_verify($password, $user->password);
      }
  }

    /**
     * Fetches the first and last name of a logged-in user
     *
     * @param $conn Database connection
     *
     * @param $email User's email address
     *
     * @return string Returns the first name of the user
     */
    public static function get_username($conn, $email) {
      $sql = 'SELECT *
              FROM user
              WHERE email = :email';

      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);

      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $firstname = $row['firstname'];
      $lastname = $row['lastname'];

      return "{$firstname} {$lastname}";
    }

    /**
     * Fetches the user ID of a logged-in user
     *
     * @param $conn Database connection
     *
     * @param $email User's email address
     *
     * @return string Returns the first name of the user
     */
    public static function get_user_id($conn, $email) {
      $sql = 'SELECT *
              FROM user
              WHERE email = :email';

      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);

      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $id = $row['userid'];

      return $id;
    }
  }
