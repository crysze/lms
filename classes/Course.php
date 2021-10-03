<?php

/**
 * Course
 *
 * A course's details
 */
class Course {
    /**
     * Unique identifier
     *
     * @var int
     */
    public $id;

        /**
     * The course category
     *
     * @var string
     */
    public $category;

    /**
     * The course title
     *
     * @var string
     */
    public $title;

    /**
     * The course image
     *
     * @var string
     */
    public $img;

    /**
     * The course description
     *
     * @var string
     */
    public $description;

      /**
     * Get the course record based on the course ID.
     *
     * @param object $conn    Connection to the database
     * @param int    $id      the course ID
     * @param string $columns Optional list of columns for the select, defaults to *
     *
     * @return mixed An object of this class, or null if not found
     */
    public static function getByID($conn, $id, $columns = '*') {
        $sql = "SELECT $columns
                FROM course
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Course');

        if ($stmt->execute()) {
            return $stmt->fetch();
        }
    }

    /**
     * Creates a new enrolment in the database
     *
     * @param object $conn Database connection
     * @param int $user_id The user ID
     * @param int $course_id the course ID
     *
     * @return bool True if the database entry has been created successfully
     */

      public static function enroll_user($conn, $user_id, $course_id) {

      $sql = 'INSERT INTO enrolment (user_id, course_id, date, progress)
              VALUES (:user_id, :course_id, :date, :progress)';

      $stmt = $conn->prepare($sql);

      date_default_timezone_set('Europe/Riga');

      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindValue(':course_id', $course_id, PDO::PARAM_INT);
      $stmt->bindValue(':date', date("Y/m/d"), PDO::PARAM_STR);
      $stmt->bindValue(':progress', 0.00, PDO::PARAM_INT);

      if ($stmt->execute()) {
        // $this->id = $conn->lastInsertId();

        return true;
        }
    }

    /**
     * Checks if a user with a given id already is enrolled in a course
     *
     * @param $conn Database connection
     *
     * @param $user_id User's ID
     *
     * @return bool True if the user is enrolled in the current course
     */
    public static function enrolment_check($conn, $user_id, $course_id) {
        $sql = 'SELECT *
                FROM enrolment
                WHERE user_id = :user_id
                AND course_id = :course_id;';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':course_id', $course_id, PDO::PARAM_INT);

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
          return true;
        } else {
          return false;
        }
      }

      public static function allEnrolments($conn, $user_id) {
        $sql = 'SELECT enrolment.date, enrolment.progress, course.id, course.title
                FROM enrolment
                INNER JOIN course ON course.id = enrolment.course_id
                WHERE enrolment.user_id = :user_id';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
      }
}
