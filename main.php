<?php

class User
{
    private $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function login($enteredUsername, $enteredPassword)
    {

        if (file_exists('users.txt')) {
            $usersData = file('users.txt', FILE_IGNORE_NEW_LINES);

            foreach ($usersData as $userData) {
                list($storedUsername, $storedPassword) = explode(',', $userData);
                echo "<script>console.log('Debug Objects: " . $enteredUsername . "' );</script>";
                if ($enteredUsername === $storedUsername && $enteredPassword === $storedPassword) {
                    return true;
                }
            }
        }
        return false;

    }


    public function register()
    {
        $file = 'users.txt';
        $data = $this->username . ',' . $this->password . "\n";
        file_put_contents($file, $data, FILE_APPEND);
    }
}

// Process the submitted form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Create a user object
    $user = new User($username, $password);

    // Determine if it's a login or registration attempt
    if (isset($_POST['login'])) {
        $enteredUsername = isset($_POST['username']) ? $_POST['username'] : '';
        $enteredPassword = isset($_POST['password']) ? $_POST['password'] : '';

        // Attempt login
        if ($user->login($enteredUsername, $enteredPassword)) {
            echo 'Login successful';
        } else {
            echo 'Invalid login credentials';
        }
    } elseif (isset($_POST['register'])) {
        // Register new user
        $user->register();
        echo 'Registration successful';
    }
}

?>