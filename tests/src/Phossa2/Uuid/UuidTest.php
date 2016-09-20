<?php

namespace Phossa2\Uuid;

/**
 * Uuid test case.
 */
class UuidTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Tests Uuid->get()
     *
     * @cover Phossa2\Uuid\Uuid::get()
     * @cover Phossa2\Uuid\Uuid::info()
     */
    public function testGet()
    {
        /*
        $uuid = Uuid::get(
            '000a', // type
            '000c' // shard
        );
        $info = Uuid::info($uuid);
        $this->assertEquals([
            'version' => '2',
            'type' => '000a',
            'shard' => '000c',
            'vendor' => '0001',
            'remain' => '0000'
        ], $info); */
    }

    /**
     * Tests Uuid->isValid()
     *
     * @cover Phossa2\Uuid\Uuid::isValid()
     */
    public function testIsValid()
    {
        /*
        $uuid = Uuid::get();
        $this->assertTrue(Uuid::isValid($uuid));
        $this->assertFalse(Uuid::isValid($uuid . 'x')); */
    }

    /**
     * Tests Uuid->encode()
     *
     * @cover Phossa2\Uuid\Uuid::encode()
     */
    public function testEncode()
    {
        /*
        $uuid = Uuid::get();
        if ($uuid === Uuid::get()) {
            $this->throwException(new \LogicException("duplication found"));
        }
        $this->assertEquals($uuid, Uuid::decode(Uuid::encode($uuid))); */
    }
}
