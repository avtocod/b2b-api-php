<?php

ini_set('error_reporting', (string) \E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// avto-dev/guzzle-url-mock 1.5.x (needed on PHP 7.2) calls GuzzleHttp\Promise\promise_for()
// and rejection_for(), which were removed in guzzlehttp/promises 2.x (Guzzle 7.10+).
if (! \function_exists('GuzzleHttp\\Promise\\promise_for')) {
    require __DIR__ . '/polyfill-guzzle-promises.php';
}
