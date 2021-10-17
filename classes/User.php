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
     * Creates a new user in the database
     *
     * @param $conn Database connection
     *
     * @return bool True if the database entry has been created successfully
     */
    public function create($conn) {

      $sql = 'INSERT INTO user (firstname, lastname, email, password)
              VALUES (:firstname, :lastname, :email, :password)';

      $stmt = $conn->prepare($sql);

      $stmt->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
      $stmt->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
      $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
      $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);

      if ($stmt->execute()) {
        $this->id = $conn->lastInsertId();

        return true;
        }
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
