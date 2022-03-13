<?php

namespace App\Models;

class User extends Model
{

    //Find user by email
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        return $this->db->rowCount() >= 1 ? $row : false;
    }

    /**
     * Register User
     */
    public function register($data)
    {
        $this->db->query('INSERT INTO users (name, email, password, role) 
        VALUES (:name, :email, :password, :role)');

        /**
         * Bind values
         **/
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':role', $data['role']);

        /**
         * Execute
         */
        return (bool)$this->db->execute();
    }

    /**
     * Login user
     **/
    public function login($email, $password)
    {
        $row = $this->findUserByEmail($email);

        if ($row == false) {
            return false;
        }

        $hashedPassword = $row->password;

        return password_verify($password, $hashedPassword) ? $row : false;
    }
}