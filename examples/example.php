<?php
// Example code
include_once('./../../../autoload.php');

/**
 * Pretty print array/object for debuging
 *
 * @param array|object $params Array/object to be print
 * @param boolean $exit Exit after print
 * @return void
 */
if (!function_exists('\pr')) {
    function pr($params, $exit = true)
    {
        echo "<pre>";
        print_r($params);
        echo "</pre>";

        if ($exit == true) {
            exit();
        }
    }
}

// Create $ServiceResponse object
$ServiceResponse = new \FR\ServiceResponse\ServiceResponse();

/*
// Override allowed error codes
$ServiceResponse->setAllowedErrorCodes([
    400 => '400 Bad Request',
    401 => '401 Unauthorized',
    403 => '403 Forbidden',
    404 => '404 Not Found',
    405 => '405 Method Not Allowed',
    415 => '415 Unsupported Media Type',
    422 => '422 Unprocessable Entity',
    429 => '429 Too Many Requests',
]);
*/

/*
// Override allowed success codes
$ServiceResponse->setAllowedSuccessCodes([
    200 => '200 OK',
    201 => '201 Created',
    202 => '202 Accepted'
]);
*/

// How to check instance type
if ($ServiceResponse instanceof \FR\ServiceResponse\ServiceResponseInterface)
    echo 'How to check instance type: \FR\ServiceResponse\ServiceResponseInterface <br>';

$response = $ServiceResponse->error(422, 'validation_errors', 'Please correct highlighted errors below.', ['validation' => 'messages'])->setNotify('error', 'Record not added due to error.')->setExtra(['something' => 'extra'])->toArray();
pr($response, false);

$response = $ServiceResponse->error(422, 'validation_errors', 'Any error message without notify.', ['validation2' => 'messages2'])->toArray();
pr($response, false);

$response = $ServiceResponse->error(400, 'invalid_username', 'Username not valid without validation messages.')->toArray();
pr($response, false);

$response = $ServiceResponse->error(400)->toArray();
pr($response, false);

$response = $ServiceResponse->success(201, ['simple' => 'data'])->setExtra(['something' => 'extra'])->setNotify('success', 'Record added successfully.')->toArray();
pr($response, false);

$response = $ServiceResponse->success(201, ['simple2' => 'data2'])->toArray();
pr($response, false);

$response = $ServiceResponse->success(201)->toArray();
pr($response, false);
