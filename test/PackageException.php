<?php

namespace Cradle\Package;

use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-07-27 at 13:49:45.
 */
class Cradle_Package_Exception_Test extends TestCase
{
  /**
   * @var FrameException
   */
  protected $object;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp()
  {
    $this->object = new PackageException;
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown()
  {
  }

  /**
   * @covers Cradle\Package\Exception::forMethodNotFound
   */
  public function testForMethodNotFound()
  {
    $message = null;

    try {
      throw PackageException::forMethodNotFound('foobar');
    } catch(PackageException $e) {
      $message = $e->getMessage();
    }

    $this->assertEquals('No method named foobar was found', $message);
  }

  /**
   * @covers Cradle\Package\Exception::forPackageNotFound
   */
  public function testForPackageNotFound()
  {
    $message = null;

    try {
      throw PackageException::forPackageNotFound('foobar');
    } catch(PackageException $e) {
      $message = $e->getMessage();
    }

    $this->assertEquals('Could not find package: foobar', $message);
  }
}
