<?php declare(strict_types=1);

@include __DIR__ . '/vendor/autoload.php';

use Kirby\Cms\App;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LogLevel;

function monolog(string $name = null): Logger
{
    return option('presprog.logger.default.channel')($name);
}

App::plugin('presprog/logger', [
    'options' => [
        'default' => [
            'name' => 'kirby',
            'maxFiles' => 14,
            'level' => LogLevel::DEBUG,
            'dir' => function () {
                return kirby()->root('logs') ?? kirby()->root('site') . '/logs';
            },
            'channel' => function (string $name = null) {
                $name     ??= option('presprog.logger.default.name');
                $path     = option('presprog.logger.default.dir')();
                $filename = $path . DIRECTORY_SEPARATOR . $name . '.log';

                return new Logger($name, [
                    new RotatingFileHandler(
                        $filename,
                        option('presprog.logger.default.maxFiles'),
                        option('presprog.logger.default.level'),
                    ),
                ]);
            },
        ],
    ],

    'siteMethods' => [
        'log' => function (string $message, ?string $level = null, ?string $name = null, array $context = []): void {
            $logger = monolog($name);

            if (null === $level) {
                $level = option('presprog.logger.default.level');
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
