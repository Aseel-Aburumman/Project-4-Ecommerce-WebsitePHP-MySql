<?php
class Validator {
    public static function validateName($name) {
        $words = explode(" ", trim($name));
        return count($words) >= 4;
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validatePassword($password) {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
    }

    public static function passwordsMatch($password, $repeatPassword) {
        return $password === $repeatPassword;
    }
}
?>
