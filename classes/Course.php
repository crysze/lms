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
     * The path to the course image
     *
     * @var string
     */
    public $path;

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
        $sql = "SELECT $columns, image.img_id, image.path
                FROM course
                INNER JOIN image ON image.img_id = course.img
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Course');

        if ($stmt->execute()) {
            return $stmt->fetch();
        }
    }

    /**
     * Get the course record based on the course category.
     *
     * @param object $conn       Connection to the database
     * @param int    $category   the course category
     *
     * @return arr A set of arrays with the query results
     */
    public static function getByCategory($conn, $category) {
      $sql = "SELECT course.id, course.title, course.category, course.img, category.category_id, category.category_title, image.img_id, image.path
              FROM course
              INNER JOIN category ON category.category_id = course.category
              INNER JOIN image ON image.img_id = course.img
              WHERE category.category_title = :category";

      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':category', $category, PDO::PARAM_STR);

      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $rows;
  }


    /**
     * Return courses whose description matches the user query
     *
     * @param object $conn    Connection to the database
     * @param int    $input   The search query input by the user
     *
     * @return arr A set of arrays with the query results based on matching course descriptions
     */
    public static function userSearch($conn, $input) {
      $sql = "SELECT course.id, course.title, course.description, image.path
              FROM course
              INNER JOIN image ON course.img = img_id";

      $stmt = $conn->prepare($sql);

      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

      // Empty array to gather all course ID's where the user input matches part of the course description

      $course_matches = [];

      foreach ($rows as $row) {
        if (str_contains(strtolower($row['description']), strtolower($input))) {
           array_push($course_matches, intval($row['id']));
        }
      }

      // Empty array to gather all results from the getByID method which returns the corresponding course as a class object

      $course_matches_data = [];

      foreach ($course_matches as $course_match) {
        array_push($course_matches_data, Course::getByID($conn, $course_match));
      }

      return $course_matches_data;
  }

      /**
     * Return courses whose assigned tags match the user query
     *
     * @param object $conn    Connection to the database
     * @param int    $input   The search query input by the user
     *
     * @return arr A set of arrays with the query results based on matching course tags
     */
    public static function tagSearch($conn, $input) {
      $sql = "SELECT tagging.tag_id, tagging.course_id, tag.tag_id, tag.tag_title
              FROM tagging
              INNER JOIN tag ON tagging.tag_id = tag.tag_id
              WHERE LOWER(tag.tag_title) = LOWER(:input)";

      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':input', $input, PDO::PARAM_STR);

      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $courseIDs = array_column($rows, 'course_id');

      $course_matches = [];

      foreach ($courseIDs as $courseID) {
        array_push($course_matches, Course::getByID($conn, $courseID));
      }

      return $course_matches;
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

    /**
     * Return all of the courses a specific user is enrolled in
     *
     * @param $conn Database connection
     *
     * @param $user_id User's ID
     *
     * @return Array An array containing all of the courses a user is enrolled in
     */

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

    /**
     * Return a user's progress in a specific course
     *
     * @param $conn Database connection
     *
     * @param $user_id User's ID
     *
     * @param $course_id The course ID
     *
     * @return Array An array containing, amongst others, the progress a user has made in a specific course
     */

      public static function getProgress($conn, $user_id, $course_id) {
        $sql = 'SELECT *
                FROM enrolment
                WHERE user_id = :user_id
                AND course_id = :course_id;';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':course_id', $course_id, PDO::PARAM_INT);

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
      }

    /**
     * Update a user's course progress in a specific course
     *
     * @param $conn Database connection
     *
     * @param $user_id User's ID
     *
     * @param $course_id The course ID
     *
     * @param $new_progress The progress to be updated
     *
     * @return Bool Returns true if the update was successful
     */

    public static function updateProgress($conn, $user_id, $course_id, $new_progress) {
      $sql = 'UPDATE enrolment
              SET progress = :new_progress
              WHERE user_id = :user_id
              AND course_id = :course_id;';

      if ($new_progress === 99) $new_progress = 100;

      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindValue(':course_id', $course_id, PDO::PARAM_INT);
      $stmt->bindValue(':new_progress', $new_progress, PDO::PARAM_INT);

      if ($stmt->execute()) {
        return true;
        }
    }

    /**
     * Create a database entry for the completion of a specific course item
     *
     * @param $conn Database connection
     *
     * @param $user_id User's ID
     *
     * @param $course_id The course ID
     *
     * @param $item_id The ID of the item within the course
     *
     * @return Bool Returns true if the insertion was successful
     */

    public static function setCompletion($conn, $user_id, $course_id, $item_id) {
      $sql = 'INSERT INTO completion (course_id, user_id, item_id)
              VALUES (:course_id, :user_id, :item_id);';

      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':course_id', $course_id, PDO::PARAM_INT);
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindValue(':item_id', $item_id, PDO::PARAM_INT);

      if ($stmt->execute()) {
        return true;
        }
    }

    /**
     * Check if a specific course item has already been completed
     *
     * @param $conn Database connection
     *
     * @param $user_id User's ID
     *
     * @param $course_id The course ID
     *
     * @param $item_id The ID of the item within the course
     *
     * @return Bool Returns true if the course item was already completed
     */

    public static function getCompletion($conn, $course_id, $user_id, $item_id) {
      $sql = 'SELECT *
      FROM completion
      WHERE course_id = :course_id
      AND user_id = :user_id
      AND item_id = :item_id;';

      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':course_id', $course_id, PDO::PARAM_INT);
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindValue(':item_id', $item_id, PDO::PARAM_INT);

      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($row) {
        return true;
      } else {
        return false;
      }
    }

     /**
     * Return all videos of a specific course
     *
     * @param $conn Database connection
     *
     * @param $course_id The course ID
     *
     * @return Array An array containing all of the videos tied to a specific course
     */

      public static function getAllVideos($conn, $course_id) {
        $sql = 'SELECT *
                FROM video
                WHERE course_id = :course_id;';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':course_id', $course_id, PDO::PARAM_INT);

        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
      }

    /**
     * Return the quiz question of a specific course
     *
     * @param $conn Database connection
     *
     * @param $course_id The course ID
     *
     * @return String A string containing the question
     */

    public static function getQuizQuestion($conn, $course_id) {
      $sql = 'SELECT text
              FROM question
              WHERE course_id = :course_id;';

      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':course_id', $course_id, PDO::PARAM_INT);

      $stmt->execute();
      $result = $stmt->fetchColumn();

      return $result;
    }

    /**
     * Return the quiz answers of a specific course
     *
     * @param $conn Database connection
     *
     * @param $course_id The course ID
     *
     * @return Array An array containing all of the answers tied to a specific question
     */

    public static function getQuizAnswers($conn, $course_id) {
      $sql = 'SELECT *
              FROM answer
              WHERE question_id = :course_id;';

      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':course_id', $course_id, PDO::PARAM_INT);

      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $rows;
    }

     /**
     * Return the quiz answers of a specific course
     *
     * @param $conn Database connection
     *
     * @param $question_id The global question ID
     *
     * @return Bool Returns true if the user's answer is the correct answer, false if it isn't
     */

    public static function validateAnswer($conn, $answer_id) {
      $sql = 'SELECT *
              FROM answer
              WHERE id = :answer_id;';

      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':answer_id', $answer_id, PDO::PARAM_INT);

      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $row[0]['correct'] === "1" ? true : false;
    }
}
