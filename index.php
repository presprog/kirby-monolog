<?php declare(strict_types=1);

@include __DIR__ . '/vendor/autoload.php';

use Kirby\Cms\App;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LogLevel;

function monolog(string $name = null): Logger
{
    return kirby()->option('presprog.logger.default')($name);
}

App::plugin('presprog/logger', [
    'options' => [
        'name' => 'kirby.log',
        'default_log_level' => LogLevel::ERROR,
        'default' => function (string $name = null) {
            if ($name === null) {
                $name = option('presprog.logger.name', 'kirby.log');
            }

            $path = kirby()->root('logs');

            if ($path === null) {
                $path = kirby()->root('site') . '/logs';
            }

            return new Logger($path . DIRECTORY_SEPARATOR . $name, [
                new RotatingFileHandler($name),
            ]);
        },
    ],

    'siteMethods' => [
        'log' => function (string $message, ?string $level = null, ?string $name = null, array $context = []): void {
            $logger = monolog($name);

            if (null === $level) {
                $level = option('presprog.logger.default_log_level');
            }

            $logger->log($level, $message, $context);
        },

        'logException' => function (Throwable $exception, ?string $level = null, ?string $name = null) {
            $logger = monolog($name);

            if (null === $level) {
                $level = LogLevel::CRITICAL;
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
