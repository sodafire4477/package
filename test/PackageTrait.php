<?php

namespace Cradle\Package;

use StdClass;
use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-07-27 at 13:49:45.
 */
class Cradle_Frame_PackageTrait_Test extends TestCase
{
  /**
   * @var PackageTrait
   */
  protected $object;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp()
  {
    $this->object = new PackageTraitStub;
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown()
  {
  }

  /**
   * covers Cradle\Package\PackageTrait::isPackage
   */
  public function testIsPackage()
  {
    $actual = $this->object->isPackage('foobar');
    $this->assertFalse($actual);

    $actual = $this->object->register('foobar')->isPackage('foobar');
    $this->assertTrue($actual);
  }

  /**
   * covers Cradle\Package\PackageTrait::package
   */
  public function testPackage()
  {
    $instance = $this->object->register('foobar')->package('foobar');
    $this->assertInstanceOf('Cradle\Package\Package', $instance);

    $trigger = false;
    try {
      $this->object->package('barfoo');
    } catch(PackageException $e) {
      $trigger = true;
    }
  }

  /**
   * covers Cradle\Package\PackageTrait::register
   * covers Cradle\Package\PackageTrait::package
   */
  public function testRegister()
  {
    //pseudo
    $instance = $this->object->register('foobar')->package('foobar');
    $this->assertInstanceOf('Cradle\Package\Package', $instance);

    //root
    $instance = $this->object->register('/foo/bar')->package('/foo/bar');
    $this->assertInstanceOf('Cradle\Package\Package', $instance);

    //vendor
    $instance = $this->object->register('foo/bar')->package('foo/bar');
    $this->assertInstanceOf('Cradle\Package\Package', $instance);
  }
}

if(!class_exists('Cradle\Frame\PackageTraitStub')) {
  class PackageTraitStub
  {
    use PackageTrait;
  }
}
