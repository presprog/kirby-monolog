<?php declare(strict_types=1);

@include __DIR__ . '/vendor/autoload.php';

use Kirby\Cms\App as Kirby;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LogLevel;

function getLogger(?string $name = null): Logger
{
    if ($name === null) {
        $name = option('presprog.logger.name');
    }

    $path = kirby()->root('logs');

    if ($path === null) {
        $path = kirby()->root('site') . '/logs';
    }

    $logger = new Logger($name);
    $logger->pushHandler(new RotatingFileHandler($path . '/' . $name));

    return $logger;
}

Kirby::plugin('presprog/logger', [
    'options' => [
        'name'      => 'kirby.log',
        'default_log_level' => LogLevel::ERROR,
    ],

    'siteMethods' => [
        'log' => function (string $message, ?string $level = null, ?string $name = null, array $context = []): void {
            $logger = getLogger($name);

            if (null === $level) {
                $level = option('presprog.logger.default_log_level', LogLevel::ERROR);
            }

            $logger->log($level, $message, $context);
        },

        'logException' => function (Throwable $exception, ?string $level = null, ?string $name = null) {
            $logger = getLogger($name);

            if (null === $level) {
                $level = LogLevel::ERROR;
            }

            $logger->log($level, $exception->getMessage(), ['stack_trace' => $exception->getTraceAsString()]);
        },
    ],

    'hooks' => [
        'system.exception' => function (Throwable $exception) {
            site()->logException($exception);
        },
    ],
]);
