<?php

namespace Model;

class Logger extends Model
{
    protected static function getTableName(): string
    {
        return 'logs';
    }
    public static function log(string $message, string $file, int $line)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("INSERT INTO {$tableName} (message, file, line, created_at) VALUES (:message, :file, :line, NOW())");
        $stmt->execute([
            ':message' => $message,
            ':file' => $file,
            ':line' => $line
        ]);
    }
}