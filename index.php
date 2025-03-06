<?php declare(strict_types=1);

@include __DIR__ . '/vendor/autoload.php';

use Kirby\Cms\App;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LogLevel;

function monolog(string|null $name = null): Logger
{
    return option('presprog.monolog.default.channel')($name);
}

App::plugin('presprog/monolog', [
    'options' => [
        'default' => [
            'name' => 'kirby',
            'maxFiles' => 14,
            'level' => LogLevel::DEBUG,
            'dir' => function () {
                return kirby()->root('logs') ?? kirby()->root('site') . '/logs';
            },
            'channel' => function (string|null $name = null) {
                $name     ??= option('presprog.monolog.default.name');
                $path     = option('presprog.monolog.default.dir')();
                $filename = $path . DIRECTORY_SEPARATOR . $name . '.log';

                return new Logger($name, [
                    new RotatingFileHandler(
                        $filename,
                        option('presprog.monolog.default.maxFiles'),
                        option('presprog.monolog.default.level'),
                    ),
                ]);
            },
        ],
    ],

    'siteMethods' => [
        'logException' => function (Throwable $exception, string|null $level = null, string|null $name = null) {
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
