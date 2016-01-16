<?php
namespace TechTest\Tests\Person;

use TechTest\Person\PersonEntity;

class PersonEntityTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var PersonEntity
	 */
	private $instance;

	public function setUp()
	{
		$this->instance = new PersonEntity();
	}

	public function testInstance()
	{
		$this->assertInstanceOf('TechTest\Person\PersonEntity', $this->instance);
	}

	public function testTestSetId() {
		$this->instance->setId(1);
		$this->assertEquals(1, $this->instance->getId());
	}

	public function testSetFirstname() {
		$this->instance->setFirstname('John');
		$this->assertEquals('John', $this->instance->getFirstname());
	}

	public function testSetSurname() {
		$this->instance->setSurname('Smith');
		$this->assertEquals('Smith', $this->instance->getSurname());
	}

	/**
	 * @depends testInstance
	 * @dataProvider notInts
	 * @expectedException \Exception
	 * @expectedExceptionMessage Person ID must be an integer
	 */
	public function testInvalidSetId($id) {
		$this->instance->setId($id);
	}

	/**
	 * @depends testInstance
	 * @dataProvider notStrings
	 * @expectedException \Exception
	 * @expectedExceptionMessage Firstname must be a string
	 */
	public function testInvalidSetFirstname($firstname) {
		$this->instance->setFirstname($firstname);
	}

	/**
	 * @depends testInstance
	 * @dataProvider notStrings
	 * @expectedException \Exception
	 * @expectedExceptionMessage Surname must be a string
	 */
	public function testInvalidSetSurname($surname) {
		$this->instance->setSurname($surname);
	}

	public function notInts() {
		return array(
			array(array()),
			array(null),
			array(false),
			array("1"),
			array(1.1),
			array(new \stdClass())
		);
	}

	public function notStrings() {
		return array(
			array(array()),
			array(null),
			array(false),
			array(1),
			array(1.1),
			array(new \stdClass())
		);
	}
}