<?php

namespace Service\Logger;

use Model\Logger;

class DbLogger implements LoggerInterface
{
    private Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger();
    }
    public function log(string $message, string $file, int $line): void
    {
        $this->logger->log($message, $file, $line);
    }
}