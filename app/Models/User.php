<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    public $id;
    public $unit_id;
    public $username;
    public $email;
    public $password;
    public $full_name;
    public $role;
    public $created_at;
    public $updated_at;

    /**
     * Find a user by their ID.
     *
     * @param int $id
     * @return User|null
     */
    public static function find($id)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    /**
     * Find a user by their username or email.
     *
     * @param string $usernameOrEmail
     * @return User|null
     */
    public static function findByUsernameOrEmail($usernameOrEmail)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username OR email = :email');
        $stmt->execute(['username' => $usernameOrEmail, 'email' => $usernameOrEmail]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return int|false The ID of the created user or false on failure.
     */
    public static function create(array $data)
    {
        $pdo = Database::getPdo();
        $sql = "INSERT INTO users (full_name, username, email, password, role) VALUES (:full_name, :username, :email, :password, :role)";

        $stmt = $pdo->prepare($sql);

        $success = $stmt->execute([
            'full_name' => $data['full_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => $data['role'] ?? 'pending',
        ]);

        return $success ? $pdo->lastInsertId() : false;
    }

    // You can add update and delete methods here as needed.
}
