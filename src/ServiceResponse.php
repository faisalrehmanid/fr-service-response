<?php

namespace FR\ServiceResponse;

class ServiceResponse implements ServiceResponseInterface
{
    /**
     * HTTP status code
     *
     * @var int
     */
    protected $code;

    /**
     * HTTP status title
     *
     * @var string
     */
    protected $title;

    /**
     * Status of service
     *
     * @var string 'error' | 'success'
     */
    protected $status;

    /**
     * Data from service
     *
     * @var array
     */
    protected $data = [];

    /**
     * Type from service
     *
     * @var string
     */
    protected $type;

    /**
     * Message from service
     *
     * @var string
     */
    protected $message;

    /**
     * Validation errors from service
     *
     * @var array
     */
    protected $validation_errors = [];

    /**
     * Notification from service
     *
     * @var array
     */
    protected $notify = [];

    /**
     * Extra from service
     *
     * @var array
     */
    protected $extra = [];

    /**
     * Default allowed HTTP error codes
     *
     * @var array
     */
    protected $allowedErrorCodes = [
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        402 => '402 Payment Required',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        405 => '405 Method Not Allowed',
        406 => '406 Not Acceptable',
        407 => '407 Proxy Authentication Required',
        408 => '408 Request Timeout',
        409 => '409 Conflict',
        410 => '410 Gone',
        411 => '411 Length Required',
        412 => '412 Precondition Failed',
        413 => '413 Payload Too Large',
        414 => '414 Request-URI Too Long',
        415 => '415 Unsupported Media Type',
        416 => '416 Requested Range Not Satisfiable',
        417 => '417 Expectation Failed',
        418 => '418 I\'m a teapot',
        421 => '421 Misdirected Request',
        422 => '422 Unprocessable Entity',
        423 => '423 Locked',
        424 => '424 Failed Dependency',
        426 => '426 Upgrade Required',
        428 => '428 Precondition Required',
        429 => '429 Too Many Requests',
        431 => '431 Request Header Fields Too Large',
        444 => '444 Connection Closed Without Response',
        451 => '451 Unavailable For Legal Reasons',
        499 => '499 Client Closed Request',
    ];

    /**
     * Default allowed HTTP success codes
     *
     * @var array
     */
    protected $allowedSuccessCodes = [
        200 => '200 OK',
        201 => '201 Created',
        202 => '202 Accepted'
    ];

    /**
     * Reset object attributes
     *
     * @return void
     */
    protected function reset()
    {
        $this->code = '';
        $this->title = '';
        $this->status = '';
        $this->data = [];
        $this->type = '';
        $this->message = '';
        $this->validation_errors = [];
        $this->notify = [];
        $this->extra = [];
    }

    /**
     * Set allowed HTTP error codes
     *
     * @param array $allowedErrorCodes
     * @return void
     */
    public function setAllowedErrorCodes(array $allowedErrorCodes)
    {
        $this->allowedErrorCodes = $allowedErrorCodes;
    }

    /**
     * Set allowed HTTP success codes
     *
     * @param array $allowedSuccessCodes
     * @return void
     */
    public function setAllowedSuccessCodes(array $allowedSuccessCodes)
    {
        $this->allowedSuccessCodes = $allowedSuccessCodes;
    }

    /**
     * Get HTTP status code
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get HTTP status title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get status of service 'error' | 'success'
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get data from service
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get type from service
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get message from service
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get validation errors from service
     *
     * @return array
     */
    public function getValidationErrors()
    {
        return $this->validation_errors;
    }

    /**
     * Get notification from service
     *
     * @return array
     */
    public function getNotify()
    {
        return $this->notify;
    }

    /**
     * Get extra from service
     *
     * @return array
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * Success response
     *
     * @param int $code
     * @param array $data
     * @throws \Exception `code` must be integer
     * @throws \Exception Invalid success code
     * @return object $this
     */
    public function success($code, array $data = [])
    {
        if (!is_int($code))
            throw new \Exception('`code` must be integer');

        $codes = $this->allowedSuccessCodes;
        if (!in_array($code, array_keys($codes)))
            throw new \Exception('Invalid success code it must be: ' . implode(', ', array_keys($codes)));

        $this->code = $code;
        $this->title = $codes[$code];
        $this->status = 'success';
        $this->data = $data;

        return $this;
    }

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
    public function error($code, $type = '', $message = '', array $validation_errors = [])
    {
        if (!is_int($code))
            throw new \Exception('`code` must be integer');

        if (!is_string($type))
            throw new \Exception('`type` must be string');

        if (!is_string($message))
            throw new \Exception('`message` must be string');

        $type = trim($type);
        $message = trim($message);

        $codes = $this->allowedErrorCodes;
        if (!in_array($code, array_keys($codes)))
            throw new \Exception('Invalid error code it must be: ' . implode(', ', array_keys($codes)));

        $this->code = $code;
        $this->title = $codes[$code];
        $this->status = 'error';
        $this->data = [];
        $this->type = $type;
        $this->message = $message;
        $this->validation_errors = $validation_errors;

        return $this;
    }

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
    public function setNotify($status, $message)
    {
        if (!is_string($status))
            throw new \Exception('`status` must be string');
        if (!is_string($message))
            throw new \Exception('`message` must be string');

        $status = trim($status);
        $message = trim($message);
        $statuses = ['success', 'error', 'warning', 'info'];
        if (!in_array($status, $statuses))
            throw new \Exception('`status` must be: ' . implode(", ", $statuses));

        if (!$message)
            throw new \Exception('`message` cannot be empty');

        $this->notify = ['status' => $status, 'message' => $message];

        return $this;
    }

    /**
     * Set extra
     *
     * @param array $extra
     * @return object $this
     */
    public function setExtra(array $extra = [])
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Get response as an array
     *
     * @return array
     */
    public function toArray()
    {
        $response = [];

        if ($this->getStatus() == 'success') {
            $response = [
                'code' => $this->getCode(),
                'title' => $this->getTitle(),
                'status' => $this->getStatus(),
                'data' => $this->getData(),
                'notify' => $this->getNotify(),
                'extra' => $this->getExtra()
            ];
        }

        if ($this->getStatus() == 'error') {
            $response = [
                'code' => $this->getCode(),
                'title' => $this->getTitle(),
                'status' => $this->getStatus(),
                'data' => $this->getData(),
                'type' => $this->getType(),
                'message' => $this->getMessage(),
                'validation_errors' => $this->getValidationErrors(),
                'notify' => $this->getNotify(),
                'extra' => $this->getExtra()
            ];
        }

        $this->reset();
        return $response;
    }

    /**
     * Get response as JSON
     *
     * @param JSON Constants $options
     * @see https://www.php.net/manual/en/json.constants.php
     * @return string JSON representation
     */
    public function toJSON($options = JSON_PRETTY_PRINT)
    {
        $response = $this->toArray();
        return json_encode($response, $options);
    }
}
