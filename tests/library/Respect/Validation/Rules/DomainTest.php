<?php
namespace Respect\Validation\Rules;

class DomainTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new Domain;
    }

    /**
     * @dataProvider providerForDomain
     *
     */
    public function testValidDomainsShouldReturnTrue($input, $tldcheck=true)
    {
        if($tldcheck === false) {
            $this->object->skipTldCheck();
        }
        $this->assertTrue($this->object->__invoke($input));
        $this->assertTrue($this->object->assert($input));
        $this->assertTrue($this->object->check($input));
        $this->object->skipTldCheck(false);
    }

    /**
     * @dataProvider providerForNotDomain
     * @expectedException Respect\Validation\Exceptions\ValidationException
     */
    public function testNotDomain($input, $tldcheck=true)
    {
        if($tldcheck === false) {
            $this->object->skipTldCheck();
        }
        $this->assertFalse($this->object->check($input));
        $this->object->skipTldCheck(false);
    }

    /**
     * @dataProvider providerForNotDomain
     * @expectedException Respect\Validation\Exceptions\DomainException
     */
    public function testNotDomainCheck($input, $tldcheck=true)
    {
        if($tldcheck === false) {
            $this->object->skipTldCheck();
        }
        $this->assertFalse($this->object->assert($input));
        $this->object->skipTldCheck(false);
    }

    public function providerForDomain()
    {
        return array(
            array(''),
            array('111111111111domain.local', false),
            array('example.com'),
            array('example-hyphen.com'),
            array('1.2.3.4'),
        );
    }

    public function providerForNotDomain()
    {
        return array(
            array(null),
            array('2222222domain.local'),
            array('example--invalid.com'),
            array('-example-invalid.com'),
            array('1.2.3.256'),
        );
    }
}

