<?php

// app/Logging/DatabaseLogger.php
namespace App\Logging;

use App\Models\Log;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class DatabaseLogger
{
    public static function createLogger(array $config)
    {
        $logger = new Logger('database');
        $logger->pushHandler(new class extends AbstractProcessingHandler {
            protected function write(LogRecord $record): void
            {
                Log::create([
                    'level' => $record->level->getName(),
                    'message' => $record->message,
                    'context' => $record->context,
                ]);
            }
        });

        return $logger;
    }
}