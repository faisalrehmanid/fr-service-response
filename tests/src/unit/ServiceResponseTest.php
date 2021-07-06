<?php

namespace FRUnitTest\ServiceResponse;

use PHPUnit\Framework\TestCase;
use FR\ServiceResponse\ServiceResponse;

class ServiceResponseTest extends TestCase
{
    protected static $ServiceResponse;

    /**
     * This method is executed only once per class
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        self::$ServiceResponse = new ServiceResponse();
    }

    /**
     * @test
     * @covers FR\ServiceResponse\ServiceResponse::success
     * 
     * @return void
     */
    public function success()
    {
        $test = [
            [
                'code' => '',
                'data' => [],
            ],
            [
                'code' => '200',
                'data' => [],
            ],
            [
                'code' => 400,
                'data' => [],
            ],
            [
                'code' => 201,
                'data' => ['simple' => 'data'],
            ],
            [
                'code' => 200,
                'data' => ['simple' => ['test' => 'data']],
            ],
        ];

        foreach ($test as $i => $param) {

            if (in_array($i, [0, 1])) {
                $exception = false;
                try {
                    invokeMethod(
                        self::$ServiceResponse,
                        'success',
                        [$param['code'], $param['data']]
                    );
                } catch (\Exception $expected) {
                    $exception = true;
                }
                $this->assertTrue($exception, 'Exception not thrown: `code` must be integer');
            }

            if (in_array($i, [2])) {
                $exception = false;
                try {
                    invokeMethod(
                        self::$ServiceResponse,
                        'success',
                        [$param['code'], $param['data']]
                    );
                } catch (\Exception $expected) {
                    $exception = true;
                }
                $codes = [
                    200 => 'OK',
                    201 => 'Created'
                ];
                $this->assertTrue($exception, 'Exception not thrown: Invalid success code it must be: ' . implode(', ', array_keys($codes)));
            }

            if (in_array($i, [3, 4])) {
                $object = invokeMethod(
                    self::$ServiceResponse,
                    'success',
                    [$param['code'], $param['data']]
                );

                $this->assertEquals($param['code'], @$object->getCode());
                $this->assertEquals($codes[$param['code']], @$object->getTitle());
                $this->assertEquals('success', @$object->getStatus());
                $this->assertTrue(($param['data'] == @$object->getData()));
            }
        }
    }

    /**
     * @test
     * @covers FR\ServiceResponse\ServiceResponse::error
     * 
     * @return void
     */
    public function error()
    {
        $test = [
            [
                'code' => '200',
                'type' => '',
                'message' => '',
                'validation_errors' => [],
            ],
            [
                'code' => 400,
                'type' => true,
                'message' => '',
                'validation_errors' => [],
            ],
            [
                'code' => 400,
                'type' => 'valid_type',
                'message' => true,
                'validation_errors' => [],
            ],
            [
                'code' => 200,
                'type' => 'valid_type',
                'message' => 'valid message',
                'validation_errors' => [],
            ],
            [
                'code' => 400,
                'type' => ' invalid_username ',
                'message' => ' Please enter valid username. ',
                'validation_errors' => ['validation' => 'messages'],
            ],
        ];

        foreach ($test as $i => $param) {

            if (in_array($i, [0])) {
                $exception = false;
                try {
                    invokeMethod(
                        self::$ServiceResponse,
                        'error',
                        [$param['code'], $param['type'], $param['message'], $param['validation_errors']]
                    );
                } catch (\Exception $expected) {
                    $exception = true;
                }
                $this->assertTrue($exception, 'Exception not thrown: `code` must be integer');
            }

            if (in_array($i, [1])) {
                $exception = false;
                try {
                    invokeMethod(
                        self::$ServiceResponse,
                        'error',
                        [$param['code'], $param['type'], $param['message'], $param['validation_errors']]
                    );
                } catch (\Exception $expected) {
                    $exception = true;
                }
                $this->assertTrue($exception, 'Exception not thrown: `type` must be string');
            }

            if (in_array($i, [2])) {
                $exception = false;
                try {
                    invokeMethod(
                        self::$ServiceResponse,
                        'error',
                        [$param['code'], $param['type'], $param['message'], $param['validation_errors']]
                    );
                } catch (\Exception $expected) {
                    $exception = true;
                }
                $this->assertTrue($exception, 'Exception not thrown: `message` must be string');
            }

            if (in_array($i, [3])) {
                $exception = false;
                try {
                    invokeMethod(
                        self::$ServiceResponse,
                        'error',
                        [$param['code'], $param['type'], $param['message'], $param['validation_errors']]
                    );
                } catch (\Exception $expected) {
                    $exception = true;
                }
                $codes = [
                    400 => 'Bad Request',
                    401 => 'Unauthorized',
                    403 => 'Forbidden',
                    404 => 'Not Found',
                    422 => 'Unprocessable Entity'
                ];
                $this->assertTrue($exception, 'Exception not thrown: Invalid error code it must be: ' . implode(', ', array_keys($codes)));
            }

            if (in_array($i, [4])) {
                $object = invokeMethod(
                    self::$ServiceResponse,
                    'error',
                    [$param['code'], $param['type'], $param['message'], $param['validation_errors']]
                );

                $this->assertEquals($param['code'], @$object->getCode());
                $this->assertEquals($codes[$param['code']], @$object->getTitle());
                $this->assertEquals('error', @$object->getStatus());
                $this->assertEmpty($object->getData());
                $this->assertEquals(trim($param['type']), @$object->getType());
                $this->assertEquals(trim($param['message']), @$object->getMessage());
                $this->assertTrue(($param['validation_errors'] == @$object->getValidationErrors()));
            }
        }
    }

    /**
     * @test
     * @covers FR\ServiceResponse\ServiceResponse::setNotify
     * 
     * @return void
     */
    public function setNotify()
    {
        $test = [
            [
                'status' => true,
                'message' => 'Sample message',
            ],
            [
                'status' => 'invalid-status',
                'message' => 'Sample message',
            ],
            [
                'status' => 'error',
                'message' => true,
            ],
            [
                'status' => 'error',
                'message' => '',
            ],
            [
                'status' => ' error ',
                'message' => ' Sample error message ',
            ],
        ];

        foreach ($test as $i => $param) {

            if (in_array($i, [0])) {
                $exception = false;
                try {
                    invokeMethod(
                        self::$ServiceResponse,
                        'setNotify',
                        [$param['status'], $param['message']]
                    );
                } catch (\Exception $expected) {
                    $exception = true;
                }
                $this->assertTrue($exception, 'Exception not thrown: `status` must be string');
            }

            if (in_array($i, [1])) {
                $exception = false;
                try {
                    invokeMethod(
                        self::$ServiceResponse,
                        'setNotify',
                        [$param['status'], $param['message']]
                    );
                } catch (\Exception $expected) {
                    $exception = true;
                }
                $statuses = ['success', 'error', 'warning', 'info'];
                $this->assertTrue($exception, 'Exception not thrown: `status` must be: ' . implode(", ", $statuses));
            }

            if (in_array($i, [2])) {
                $exception = false;
                try {
                    invokeMethod(
                        self::$ServiceResponse,
                        'setNotify',
                        [$param['status'], $param['message']]
                    );
                } catch (\Exception $expected) {
                    $exception = true;
                }
                $this->assertTrue($exception, 'Exception not thrown: `message` must be string');
            }

            if (in_array($i, [3])) {
                $exception = false;
                try {
                    invokeMethod(
                        self::$ServiceResponse,
                        'setNotify',
                        [$param['status'], $param['message']]
                    );
                } catch (\Exception $expected) {
                    $exception = true;
                }
                $this->assertTrue($exception, 'Exception not thrown: `message` cannot be empty');
            }

            if (in_array($i, [4])) {
                $object = invokeMethod(
                    self::$ServiceResponse,
                    'setNotify',
                    [$param['status'], $param['message']]
                );

                @$notify = $object->getNotify();
                $this->assertIsArray($notify);
                $this->assertNotEmpty($notify);
                $this->assertArrayHasKey('status', @$notify);
                $this->assertArrayHasKey('message', @$notify);
                $this->assertEquals(trim($param['status']), $notify['status']);
                $this->assertEquals(trim($param['message']), $notify['message']);
            }
        }
    }

    /**
     * @test
     * @covers FR\ServiceResponse\ServiceResponse::toArray
     * 
     * @return void
     */
    public function toArray()
    {
        // Error response
        $test = [
            [
                'code' => 422,
                'type' => 'validation_errors',
                'message' => 'Please correct highlighted errors below.',
                'validation_errors' => ['validation' => 'messages'],
                'notify' => [
                    'status' => 'error',
                    'message' => 'Record not added due to error.'
                ],
                'extra' => ['something' => 'extra']
            ],
            [
                'code' => 400,
                'type' => '',
                'message' => '',
                'validation_errors' => [],
                'notify' => [],
                'extra' => ['something' => 'extra']
            ]
        ];

        foreach ($test as $i => $param) {
            $object = self::$ServiceResponse->error(
                $param['code'],
                $param['type'],
                $param['message'],
                $param['validation_errors']
            );

            if (!empty($param['extra']))
                $object = $object->setExtra($param['extra']);

            if (!empty($param['notify']))
                $object = $object->setNotify($param['notify']['status'], $param['notify']['message']);

            $response = $object->toArray();
            $this->assertIsArray($response);
            $this->assertNotEmpty($response);
            $this->assertArrayHasKey('code', $response);
            $this->assertArrayHasKey('title', $response);
            $this->assertArrayHasKey('status', $response);
            $this->assertArrayHasKey('notify', $response);
            $this->assertArrayHasKey('data', $response);
            $this->assertArrayHasKey('type', $response);
            $this->assertArrayHasKey('message', $response);
            $this->assertArrayHasKey('validation_errors', $response);
            $this->assertArrayHasKey('extra', $response);
        }
    }
}
