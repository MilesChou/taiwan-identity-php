<?php

namespace Tests;

use Validentity\TaiwanForeign;

class TaiwanForeignTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TaiwanForeign
     */
    private $target;

    protected function setUp()
    {
        $this->target = new TaiwanForeign();
    }

    protected function tearDown()
    {
        $this->target = null;
    }

    public function invalidArguments()
    {
        return [
            ['NULL', null],
            ['bool', true],
            ['bool', false],
            ['int', 0],
            ['int', 1],
            ['double', 1.0],
            ['array', []],
            ['object', new \stdClass()],
        ];
    }

    /**
     * @test
     * @dataProvider invalidArguments
     */
    public function shouldThrowExceptionWhenCallNormalizeWithInvalidArguments($exceptedType, $invalidArguments)
    {
        $this->setExpectedException('InvalidArgumentException', $exceptedType);

        $this->target->normalize($invalidArguments);
    }

    public function invalidId()
    {
        return [
            ['a123456789'],
            ['AA00000000'],
            ['A0123456789'],
            ['A9876543210'],
            ['@123456789'],
            ['0123456789'],
            ['中123456789'],
        ];
    }

    /**
     * @test
     * @dataProvider invalidId
     */
    public function shouldReturnFalseWhenGotInvalidId($invalidId)
    {
        $this->assertFalse($this->target->check($invalidId));
    }

    public function validId()
    {
        return [
            ['AC01234567'],
            ['FA12345689'],
            ['HD12345678'],
            ['HD12345570'],
        ];
    }

    /**
     * @test
     * @dataProvider validId
     */
    public function shouldReturnTrueWhenGotValidId($id)
    {
        $this->assertTrue($this->target->check($id));
    }
}
