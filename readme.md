# 📜 Monolog for Kirby CMS

This plugin adds the [Monolog logging library](https://github.com/Seldaek/monolog) to Kirby.

## 🤟Usage

Use the `monolog()` helper function:

```php
// Write to the default log file
monolog()->log('something happend 😱');

// Log to another channel (only changes the filename for now)
// Will log to "your-log-dir/other-channel-$date.log"
monolog('other-channel')->log('something happend 😱');

// Change the log level (any of \Psr\Log\LogLevel)
monolog()->log('something CRITICAL happend 😱', 'critical');

// …
```

If you throw and handle exceptions in your own code, you may log them with `site()->logException()`:

```php
try {
    // ..
} catch(\Exception $exception) {
    site()->logException($exception)
}
```

This will log the exception message with `critical` level alongside the stack trace.

The plugin also automatically listens to Kirby `system.exception` hook and logs the exception message as well as the stacktrace to the default log file.

## 💻 How to install

**via Composer** (recommended)

```bash
$ composer require presprog/kirby-monolog:^0.1
```

**via ZIP archive**

Download the ZIP archive, extract it into your plugins folder (defaults to `site/plugins`) and rename the subfolder to `monolog`.

## ✅ To do
* [ ] Define more channels via the config file
* [ ] …

## Alternatives

There are plenty of alternatives:
* [bnomei/monolog](https://getkirby.com/plugins/bnomei/monolog) by Bruno Meilick (This one also integrates Monolog)
* [johannschopplich/kirbylog](https://getkirby.com/plugins/johannschopplich/kirbylog) by Johann Schopplich (This one is dependency-free!)
* [michnhokn/logger](https://getkirby.com/plugins/michnhokn/logger) by Michael Scheurich
* [bvdputte/log](https://getkirby.com/plugins/bvdputte/log) by Bert Vandeputte

----

Made with ♥️ and ☕ by [Present Progressive](https://www.presentprogressive.de)
