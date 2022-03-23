<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function register()
    {
        /**
         * $_POST data filtration
         */
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'passwordRepeat' => trim($_POST['passwordRepeat']),
            'role' => 'user',
        ];


        if (!preg_match("/^[a-zA-Z0-9]*$/", $data['name'])) {
            flash("error", "Invalid name", "danger");
            redirect("/signup");
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            flash("error", "Invalid email", "danger");
            redirect("/signup");
        }

        if (strlen($data['password']) < 6) {
            flash("error", "Password must be contain more than 6 symbols", "danger");
            redirect("/signup");
        } else if ($data['password'] !== $data['passwordRepeat']) {
            flash("error", "Passwords don't match", "danger");
            redirect("/signup");
        }

        /**
         * check if user with the same email or password already exists
         */
        if ($this->userModel->findUserByEmail($data['email'])) {
            flash("error", "Email already taken", "danger");
            redirect("/signup");
        }

        /**
         * Validation passed,
         * password hashing,
         * fire a model to register
         */
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if ($this->userModel->register($data)) {
            flash("success", "Now you are registered, please log in", "success");
            redirect("/auth");
        } else {
            die("Something went wrong");
        }
    }

    public function login()
    {
        /**
         * $_POST data filtration
         */
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password'])
        ];

        if (empty($data['email']) || empty($data['password'])) {
            flash("error", "Please fill out all inputs", 'danger');
            redirect("/auth");
            exit();
        }

        //Check for user/email
        if ($this->userModel->findUserByEmail($data['email'])) {
            //User Found
            $loggedInUser = $this->userModel->login($data['email'], $data['password']);
            if ($loggedInUser) {
                //Create session
                $this->createUserSession($loggedInUser);
            } else {
                flash("error", "Password Incorrect", 'danger');
                redirect("/auth");
            }
        } else {
            flash("error", "No user with email: " . $data['email'] . " was found", 'danger');
            redirect("/auth");
        }
    }

    public function logout()
    {
        $_COOKIE = [];
        $_SESSION = [];
        session_destroy();
        redirect("/auth");
    }

    private function createUserSession($user)
    {
        $_SESSION['usersId'] = $user->id;
        $_SESSION['usersName'] = $user->name;
        $_SESSION['usersEmail'] = $user->email;
        $_SESSION['usersRole'] = $user->role;
        $_SESSION['is_auth'] = true;
        redirect("/");
    }
}