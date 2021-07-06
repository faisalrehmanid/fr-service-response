<?php

namespace FR\ServiceResponse;

interface ServiceResponseInterface
{
    /**
     * Set allowed HTTP error codes
     *
     * @param array $allowedErrorCodes
     * @return void
     */
    public function setAllowedErrorCodes(array $allowedErrorCodes);

    /**
     * Set allowed HTTP success codes
     *
     * @param array $allowedSuccessCodes
     * @return void
     */
    public function setAllowedSuccessCodes(array $allowedSuccessCodes);

    /**
     * Get HTTP status code
     *
     * @return int
     */
    public function getCode();

    /**
     * Get HTTP status title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get status of service 'error' | 'success'
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get notification from service
     *
     * @return array
     */
    public function getNotify();

    /**
     * Get data from service
     *
     * @return array
     */
    public function getData();

    /**
     * Get type from service
     *
     * @return string
     */
    public function getType();

    /**
     * Get message from service
     *
     * @return string
     */
    public function getMessage();

    /**
     * Get validation errors from service
     *
     * @return array
     */
    public function getValidationErrors();

    /**
     * Success response
     *
     * @param int $code
     * @param array $data
     * @throws \Exception `code` must be integer
     * @throws \Exception Invalid success code
     * @return object $this
     */
    public function success($code, array $data = []);

    /**
     * Error response
     *
     * @param int $code
     * @param string $type
     * @param string $message
     * @param array $validation_errors
     * @throws \Exception `code` must be integer
     * @throws \Exception `type` must be string
     * @throws \Exception `message` must be string
     * @throws \Exception Invalid error code
     * @return object $this
     */
    public function error($code, $type = '', $message = '', array $validation_errors = []);

    /**
     * Set notification
     *
     * @param string $status 'success' | 'error' | 'warning' | 'info'
     * @param string $message
     * @throws \Exception `status` must be string
     * @throws \Exception `status` must be: success, error, warning, info
     * @throws \Exception `message` must be string
     * @throws \Exception `message` cannot be empty
     * @return object $this
     */
    public function setNotify($status, $message);

    /**
     * Set extra
     *
     * @param array $extra
     * @return object $this
     */
    public function setExtra(array $extra = []);

    /**
     * Get response as an array
     *
     * @return array
     */
    public function toArray();

    /**
     * Get response as JSON
     *
     * @param JSON Constants $options
     * @see https://www.php.net/manual/en/json.constants.php
     * @return string JSON representation
     */
    public function toJSON($options = JSON_PRETTY_PRINT);
}
