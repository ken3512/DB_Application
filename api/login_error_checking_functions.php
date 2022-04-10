<?php
    /**
     * Login functions
     */

    // Check the login form is empty or not when they submit
    function loginInputIsEmpty($username, $pass) {
        $result = false;
        if (empty($username) || empty($pass)) {
            $result = true;
        }
        return $result;
    }
