<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Poll
{
    public $id;
    public $question;
    public $options;
    public $created_by;
    public $is_active;

    /**
     * Get all active polls.
     *
     * @return array
     */
    public static function getActivePolls()
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->query('SELECT * FROM polls WHERE is_active = 1');
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Create a new poll.
     *
     * @param string $question
     * @param array $options
     * @param int $userId
     * @return bool
     */
    public static function create($question, array $options, $userId)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('INSERT INTO polls (question, options, created_by) VALUES (:question, :options, :created_by)');
        return $stmt->execute([
            'question' => $question,
            'options' => json_encode($options),
            'created_by' => $userId,
        ]);
    }

    /**
     * Record a user's vote.
     *
     * @param int $pollId
     * @param int $userId
     * @param int $optionIndex
     * @return bool
     */
    public static function vote($pollId, $userId, $optionIndex)
    {
        $pdo = Database::getPdo();
        // First, check if the user has already voted.
        $stmtCheck = $pdo->prepare('SELECT id FROM poll_votes WHERE poll_id = :poll_id AND user_id = :user_id');
        $stmtCheck->execute(['poll_id' => $pollId, 'user_id' => $userId]);
        if ($stmtCheck->fetch()) {
            return false; // User has already voted.
        }

        $stmt = $pdo->prepare('INSERT INTO poll_votes (poll_id, user_id, vote_option) VALUES (:poll_id, :user_id, :vote_option)');
        return $stmt->execute([
            'poll_id' => $pollId,
            'user_id' => $userId,
            'vote_option' => $optionIndex,
        ]);
    }

    /**
     * Get the results of a poll.
     *
     * @param int $pollId
     * @return array
     */
    public static function getResults($pollId)
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('SELECT vote_option, COUNT(id) as vote_count FROM poll_votes WHERE poll_id = :poll_id GROUP BY vote_option');
        $stmt->execute(['poll_id' => $pollId]);
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }
}
