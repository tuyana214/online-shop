<?php

namespace Service\Logger;

interface LoggerInterface
{
    public function log(string $message, string $file, int $line): void;
}