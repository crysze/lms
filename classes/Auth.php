<?php

/**
 * Authentication - login
 *
*/
class Auth {

/**
     * Log in using the session
     *
     * @return void
     */
    public static function login() {
        session_regenerate_id(true);
        $_SESSION['is_logged_in'] = true;
    }
}
