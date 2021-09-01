<?php

declare(strict_types=1);

namespace pointybeard\Symphony\Extensions\Logger_Monolog;

use Symphony;
use Symphony\Symphony\AbstractLog;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Throwable;

class Monolog Extends AbstractLog
{
    private $logger = null;

    private static $PHPErrorConstantsToMonologLogLevels = [
        E_ERROR => Logger::ERROR,
        E_WARNING => Logger::WARNING,
        E_NOTICE => Logger::NOTICE,
        E_USER_ERROR => Logger::ERROR,
        E_USER_WARNING => Logger::WARNING,
        E_USER_NOTICE => Logger::NOTICE,
        E_STRICT => Logger::WARNING,
        E_RECOVERABLE_ERROR => Logger::ERROR,
        E_DEPRECATED => Logger::WARNING,
        E_USER_DEPRECATED => Logger::WARNING,
        E_ALL => Logger::INFO,
    ];

    public function & getLogger(): Logger
    {
        return $this->logger;
    }

    public function writeToLog(string $message, bool $addbreak = true): bool
    {
        $this->logger->log($message, Logger::E_NOTICE);
    }

    public function open(int $flag = self::APPEND, int $mode = 0777): int
    {
        $this->logger = new Logger("main");
        $this->logger->pushHandler(new StreamHandler(
            $this->getLogPath(),
            Symphony::Configuration()->get('logger_monolog', 'level') ?? Logger::WARNING
        ));
        return 2;
    }

    public function close(): void
    {
        // meh
    }

    public function initialise(string $name): void
    {
        // meh
    }

    public function pushExceptionToLog(Throwable $exception, bool $writeToLog = false, bool $addbreak = true, bool $append = false, array $context = []): ?bool
    {
        return $this->logger->log(Logger::ERROR, sprintf(
            '%s %s - %s on line %d of %s',
            get_class($exception),
            $exception->getCode(),
            $exception->getMessage(),
            $exception->getLine(),
            $exception->getFile()
        ), array_merge(['exception' => $exception], $context));
    }

    public function pushToLog(string $message, ?int $type = E_NOTICE, bool $writeToLog = false, bool $addbreak = true, bool $append = false, array $context = []): ?bool
    {
        $type = $type ?? E_ERROR;

        // (guard) Filtering is set to filter out this type of message
        if(false == $writeToLog || false == ($this->_filter & $type)) {
            return true;
        }

        $this->logger->log(self::$PHPErrorConstantsToMonologLogLevels[$type] ?? Logger::NOTICE, $message, $context);

        return true;

    }
}
