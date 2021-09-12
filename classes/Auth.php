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

    /**
     * Log out using the session
     *
     * @return void
     */
    public static function logout() {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }
}
