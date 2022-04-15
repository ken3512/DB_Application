<?php
    /**
     * TODO:
     *  How can we increase security?
     * -- Backup email?
     * -- Change username/email/password?
     * -- 2 factor authentication? 
     *    -- Text/Email code to verify user
     */
    
    // Check if any value is empty
    function signupInputIsEmpty($UniversityID, $Username, $Name, $Password, $ConfirmPassword, $Gmail) {
        $result = false;
        if (empty($UniversityID) || empty($Username) || empty($Name) || empty($Password) || empty($ConfirmPassword) || empty($Gmail)) {
            $result = true;
        }
        return $result;
    }

    // Check if the username is invalid
    /**
     * Must start with a lowercase or uppercase letter
     * Must be 3 to 32 characters in length
     * Cannot contain any special characters
     */
    function usernameIsInvalid($Name) {
        $result = false;
        // Check if the username is invalid, if the username is invalid return true so show that the username is invalid
        if (!preg_match('/^[A-Za-z][A-Za-z0-9]{2,31}$/', $Name)) {
            $result = true;
        }
        return $result;
    }
    
    // Check if the password is too simple
    /**
     * 1. (?=.*\d)             At least a digit
     * 2. (?=.*[a-z])          At least a lower case letter
     * 3. (?=.*[A-Z])          At least an upper case letter
     * 4. (?!.*)               No space
     * 5. (?=.*[^a-zA-Z0-9])   At least a character except a-zA-Z0-9
     * 6. .{8,32}              Between 8 to 32 characters
     */
    function passwordIsTooSimple($Password) {
        $result = false;
        // Check if the password is complex enough return true if it is too simple
        if (!preg_match("/^^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,32}$/", $Password)) {
            $result = true;
        }
        return $result;
    }

    function passwordsDoNotMatch($Password, $ConfirmPassword) {
        $result = true;
        // If the passwords match then return false that there is no error
        if ($Password === $ConfirmPassword) {
            $result = false;
        }
        return $result;
    }    

    // The easiest and safest way to check whether an email address is well-formed is to use PHP's filter_var() function.
    function emailIsInvalid($Gmail) {
        $result = false;
        if (!filter_var($Gmail, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        }
        return $result;
    }

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