<?php

namespace Service\Logger;

class FileLogger implements LoggerInterface
{
    private string $dataFile;

    public function __construct()
    {
        $this->dataFile = '../Storage/Log/errors.txt';
    }

    public function log(string $message, string $file, int $line): void
    {
        $logMessage = sprintf("[%s] ОШИБКА: %s в %s в строке номер %d\n", date('Y-m-d H:i:s'), $message, $file, $line);
        file_put_contents($this->dataFile, $logMessage, FILE_APPEND);
    }
}