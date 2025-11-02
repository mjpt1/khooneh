<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Attachment
{
    /**
     * Create a new attachment record.
     *
     * @param array $data
     * @return int|false The ID of the created attachment or false on failure.
     */
    public static function create(array $data)
    {
        $pdo = Database::getPdo();
        $sql = "INSERT INTO attachments (attachable_id, attachable_type, file_path, original_filename, mime_type, uploaded_by)
                VALUES (:attachable_id, :attachable_type, :file_path, :original_filename, :mime_type, :uploaded_by)";

        $stmt = $pdo->prepare($sql);

        $success = $stmt->execute([
            'attachable_id' => $data['attachable_id'],
            'attachable_type' => $data['attachable_type'],
            'file_path' => $data['file_path'],
            'original_filename' => $data['original_filename'],
            'mime_type' => $data['mime_type'],
            'uploaded_by' => $data['uploaded_by'],
        ]);

        return $success ? $pdo->lastInsertId() : false;
    }
}
