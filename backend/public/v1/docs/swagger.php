<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../vendor/autoload.php';

if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    define('BASE_URL', 'imao sam problem sa 404 not found error-om i nisam uspio da ovo zavrsim');
} else {
    define('BASE_URL', 'imao sam problem sa 404 not found error-om i nisam uspio da ovo zavrsim');
}

use OpenApi\Generator;

$openapi = Generator::scan([
    __DIR__ . '/doc_setup.php',
    __DIR__ . '/../../../routes'
]);

header('Content-Type: application/json');
echo $openapi->toJson();